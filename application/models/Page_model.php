<?php

/**
 * Class Page_model
 */
class Page_model extends Base_model
{

    const STATUS_ENABLED = 1;
    const STATUS_NOT_ENABLED = 0;
    const STATUS_MAIN_PAGE = 1;

    const TEMPLATE_ALL = '<:all>';
    const TEMPLATE_ALIAS = '<:alias>';

    /**
     * Current language
     * @var string
     */
    private $currentLanguage = 'en';

    /**
     * @param $uri
     * @throws NotFoundException
     * @return mixed
     */
    public function getPage($uri)
    {
        $response = $this->detectPagination($uri, $_SERVER['QUERY_STRING']);

        if (empty($response['uri'])) {
            $this->queryBuildExistedItems();
            $this->db->where(array(
                'isMainPage' => self::STATUS_MAIN_PAGE
            ));
            $page = $this->db->get(DatabaseTableEnum::TABLE_PAGE)->row();
            if (!isset($page)) {
                throw new NotFoundException();
            }
        } else {
            $page = $this->findPage($response['uri']);
        }
        $page->baseURI = $response['uri'];

        /**
         * If the pagination is tuned on
         */
        if ($page->isPaginationOn) {
            $response['isPagination'] = true;

            /**
             * Set default page 1 if the pagination page number is absent
             */
            if (!array_key_exists('paginationPage', $response)) {
                $response['paginationPage'] = 1;
            }

            /**
             * If the pagination type of the page does not equal to the detected pagination
             */
            if ($response['paginationID'] != $page->paginationID) {

                /**
                 * If the pagination was detected by GET parameter
                 * than just ignore it
                 * Else throw NotFoundException
                 */
                if (isset($response['isUriGetParameter'])) {
                    $response['paginationPage'] = 1;
                } else {
                    if (isset($response['paginationID'])) {
                        throw new NotFoundException();
                    }
                }
            }
        } else {
            if ($response['isPagination'] && !isset($response['isUriGetParameter'])) {
                throw new NotFoundException();
            }
        }

        /**
         * Retrieve all children pages due to the pagination configuration
         * and get the total count to form widget buttons
         */
        $page->children = $this->getChildPages($page, $response['isPagination'] ? $response['paginationPage'] : null);
        foreach ($page->children as $child) {
            $child->url = $this->getDefaultPageRoute($child);
            $this->loadPageMultilingualFields($child);
        }
        $page->childrenCount = $this->getChildPages($page, null, true);

        /**
         * Get all parent pages
         */
        $page->parents = $this->getParentPages($page);

        /**
         * Load all multilingual fields
         */
        $this->loadPageMultilingualFields($page);

        /**
         * Load extra fields
         */
        $this->loadPageExtraFields($page);

        /**
         * Get next and previous pages
         * Also build breadcrumb
         */
        $this->getSiblingPages($page);

        /**
         * Prepare URL routes to the page
         */
        $page->routes = $this->getPageRoutes($page);

        /**
         * Get the alias of the page
         * basing on routes
         */
        $page->alias = $this->getPageAlias($page);

        /**
         * Get carcass and inner template
         */
        $page->carcass = $this->getPageCarcass($page);
        $page->template = $this->getPageTemplate($page);

        return $page;
    }

    /**
     * @param $uri
     * @throws NotFoundException
     * @return mixed
     */
    private function findPage($uri)
    {
        $this->db->order_by('priority');
        $routes = $this->getRecords(DatabaseTableEnum::TABLE_ROUTE);
        foreach ($routes as $route) {

            /**
             * Prepare regular expressions to find the appropriate
             */
            $regexLink = str_replace('/', '\/', $route->link);
            $regexLink = str_replace(self::TEMPLATE_ALIAS, '([^\/]{1,})', $regexLink);
            $regexLink = '/' . str_replace(self::TEMPLATE_ALL, '([\s\S]{1,})', $regexLink) . '/';
            $matches = array();

            /**
             * Check if the regular expressions corresponds to the current route
             */
            if (preg_match($regexLink, $uri, $matches)) {

                /**
                 * Find the number of occurrences
                 * Get the last URL segment as alias
                 */
                $allOccurrences = substr_count($route->link, self::TEMPLATE_ALL);
                $aliasOccurrences = substr_count($route->link, self::TEMPLATE_ALIAS);
                if ($allOccurrences > 0) {
                    $alias = $matches[1];
                } else {
                    $alias = $matches[$aliasOccurrences];
                }
                $page = $this->findPageByAlias($alias, $route);
                $page->parentsURL = [];

                /**
                 * If some occurrences where detected
                 * then try to extract parent items by aliases
                 */
                if ($aliasOccurrences > 1) {
                    for ($i = $aliasOccurrences - 1; $i > 0; $i--) {
                        try {
                            $parentPage = $this->findPageByAlias($matches[$i]);
                            $page->parentsURL[] = $parentPage;
                        } catch (NotFoundException $ex) {
                        }
                    }
                }
                return $page;
            }
        }
        throw new NotFoundException();
    }

    /**
     * Find page by the given alias and route
     * @param $alias
     * @param $route
     * @throws NotFoundException
     * @return mixed
     */
    private function findPageByAlias($alias, $route = null)
    {
        if (isset($route)) {
            $this->db->where(array(
                'routeID' => $route->id
            ));
        }
        $this->db->where(array(
            'alias' => $alias
        ));
        $record = $this->db->get(DatabaseTableEnum::TABLE_PAGE_ROUTE)->row();
        if (isset($record)) {
            $this->queryBuildExistedItems();
            $this->db->where(array(
                'id'        => $record->pageID,
                'isEnabled' => self::STATUS_ENABLED
            ));
            $page = $this->db->get(DatabaseTableEnum::TABLE_PAGE)->row();
            if (isset($page)) {
                return $page;
            }
        }
        throw new NotFoundException();
    }

    /**
     * @param $uri
     * @param $uriGetString
     * @return array
     */
    private function detectPagination($uri, $uriGetString)
    {
        $paginationRecords = $this->getRecords(DatabaseTableEnum::TABLE_PAGINATION);
        $changedURI = '/' . $uri;
        $response = array(
            'uri'          => $uri,
            'isPagination' => false,
            'paginationID' => null
        );
        foreach ($paginationRecords as $paginationRecord) {
            $regexTemplate = str_replace('/', '\/', $paginationRecord->template);
            $regexLink = '/' . str_replace('<:page>', '([^\/]{1,})', $regexTemplate) . '/';
            $matches = array();

            /**
             * If the pagination is detected in the URL segment
             */
            if (preg_match($regexLink, $changedURI, $matches)) {
                $response['uri'] = str_replace($matches[0], "", $changedURI);
                $response['isPagination'] = true;
                $response['paginationPage'] = $matches[1];
                $response['paginationID'] = $paginationRecord->id;
                break;
            }

            /**
             * If the pagination is detected in GET parameters
             */
            if (preg_match($regexLink, $uriGetString, $matches)) {
                $response['isPagination'] = true;
                $response['paginationPage'] = $matches[1];
                $response['paginationID'] = $paginationRecord->id;
                $response['isUriGetParameter'] = true;
                break;
            }
        }
        return $response;
    }

    /**
     * @param $page
     * @param null $paginationPage
     * @param $count
     * @return mixed
     */
    private function getChildPages($page, $paginationPage = null, $count = false)
    {
        $this->db->select(DatabaseTableEnum::TABLE_PAGE . '.*');
        $this->db->from(DatabaseTableEnum::TABLE_PAGE);
        $this->db->join(DatabaseTableEnum::TABLE_PAGE_PAGE, DatabaseTableEnum::TABLE_PAGE_PAGE . '.pageChildID = ' . DatabaseTableEnum::TABLE_PAGE . '.id');
        $this->db->where(array(
            DatabaseTableEnum::TABLE_PAGE_PAGE . '.pageParentID' => $page->id,
            DatabaseTableEnum::TABLE_PAGE . '.isDeleted'         => self::STATUS_NOT_DELETED,
            DatabaseTableEnum::TABLE_PAGE . '.isEnabled'         => self::STATUS_ENABLED
        ));
        $this->db->order_by('sort');
        if ($page->isPaginationOn && isset($paginationPage) && !$count) {
            $this->db->limit($page->paginationPerPage, ($paginationPage - 1) * $page->paginationPerPage);
        }
        $query = $this->db->distinct();
        return $count ? $query->count_all_results() : $query->get()->result();
    }

    /**
     * @param $page
     * @return mixed
     */
    private function getParentPages($page)
    {
        $this->db->select(DatabaseTableEnum::TABLE_PAGE . '.*');
        $this->db->from(DatabaseTableEnum::TABLE_PAGE);
        $this->db->join(DatabaseTableEnum::TABLE_PAGE_PAGE, DatabaseTableEnum::TABLE_PAGE_PAGE . '.pageParentID = ' . DatabaseTableEnum::TABLE_PAGE . '.id');
        $this->db->where(array(
            DatabaseTableEnum::TABLE_PAGE_PAGE . '.pageChildID' => $page->id,
            DatabaseTableEnum::TABLE_PAGE . '.isDeleted'        => self::STATUS_NOT_DELETED,
            DatabaseTableEnum::TABLE_PAGE . '.isEnabled'        => self::STATUS_ENABLED
        ));
        $this->db->order_by('sort');
        $this->db->distinct();
        return $this->db->get()->result();
    }

    /**
     * @param $page
     */
    private function getSiblingPages($page)
    {
        $currentParentPage = null;
        $page->next = null;
        $page->previous = null;
        $page->breadcrumb = array(
            $page->id => array(
                'title' => $page->title,
                'url'   => current_url()
            )
        );

        /**
         * Try to search the current parent page
         * to fetch previous and next pages
         */
        if (!empty($page->parentsURL)) {
            foreach ($page->parentsURL as $parentURL) {
                foreach ($page->parents as $parent) {
                    if ($parent->id == $parentURL->id) {
                        $currentParentPage = $parent;
                        break;
                    }
                }
            }
        } elseif (!empty($page->parents)) {
            $currentParentPage = reset($page->parents);
        }

        /**
         * If the current parent page was detected
         * than search siblings
         * Also build breadcrumbs data
         */
        if (isset($currentParentPage)) {
            $page->next = $this->getChildPageBySort($currentParentPage->id, $page->sort, '>');
            $page->previous = $this->getChildPageBySort($currentParentPage->id, $page->sort, '<');

            /**
             * Build breadcrumbs if it is needed
             */
            if ($this->config->item('breadcrumbs')) {
                $page->breadcrumb = array_merge($page->breadcrumb, $this->buildBreadcrumb($currentParentPage));
            }
        }
    }

    /**
     * @param $parentPageID
     * @param $sort
     * @param $operator
     * @return mixed
     */
    private function getChildPageBySort($parentPageID, $sort, $operator)
    {
        $this->db->select(DatabaseTableEnum::TABLE_PAGE . '.*');
        $this->db->from(DatabaseTableEnum::TABLE_PAGE);
        $this->db->join(DatabaseTableEnum::TABLE_PAGE_PAGE, DatabaseTableEnum::TABLE_PAGE_PAGE . '.pageChildID = ' . DatabaseTableEnum::TABLE_PAGE . '.id');
        $this->db->where(array(
            DatabaseTableEnum::TABLE_PAGE_PAGE . '.pageParentID' => $parentPageID,
            DatabaseTableEnum::TABLE_PAGE . '.isDeleted'         => self::STATUS_NOT_DELETED,
            DatabaseTableEnum::TABLE_PAGE . '.isEnabled'         => self::STATUS_ENABLED
        ));
        $this->db->where('sort ' . $operator, $sort);
        $this->db->order_by('sort', 'DESC');
        $this->db->distinct();
        $page = $this->db->get()->row();
        if (isset($page)) {
            $this->loadPageMultilingualFields($page);
            $page->url = $this->getDefaultPageRoute($page);
        }
        return $page;
    }

    /**
     * @param $page
     * @return array
     */
    private function buildBreadcrumb($page)
    {
        $parentPages = $this->getParentPages($page);
        $this->loadPageMultilingualFields($page);
        $page->breadcrumb = array(
            $page->id => array(
                'title' => $page->title,
                'url'   => $this->getDefaultPageRoute($page)
            )
        );
        if (!empty($parentPages)) {
            $parentPage = reset($parentPages);
            $page->breadcrumb = array_merge($page->breadcrumb, $this->buildBreadcrumb($parentPage));
        }
        return $page->breadcrumb;
    }

    /**
     * @param $page
     */
    private function loadPageMultilingualFields($page)
    {
        $row = $this->db->where(array(
            'language' => $this->currentLanguage,
            'pageID'   => $page->id
        ))->get(DatabaseTableEnum::TABLE_PAGE_LANGUAGE)->row();
        if (!empty($row)) {
            $fields = get_object_vars($row);
            $excludeFields = array('id', 'language', 'pageID');
            foreach ($fields as $fieldName => $value) {
                if (!in_array($fieldName, $excludeFields)) {
                    $page->{$fieldName} = $row->{$fieldName};
                }
            }
        }
    }

    /**
     * @param $page
     */
    private function loadPageExtraFields($page)
    {
        $page->extraFields = array();
        $records = $this->db->select()
            ->from(DatabaseTableEnum::TABLE_PAGE_EXTRA)
            ->where(array(
                'pageID' => $page->id
            ))
            ->get()->result();
        foreach ($records as $record) {
            $page->extraFields[$record->fieldName] = $record->fieldValue;
        }
    }

    /**
     * @param $page
     * @return string
     */
    private function getPageAlias($page)
    {
        foreach ($page->routes as $pageRoute) {
            return $pageRoute->alias;
        }
        return '';
    }

    /**
     * @param $page
     * @return mixed
     */
    private function getPageRoutes($page)
    {
        $pageRoutes = $this->db->join(DatabaseTableEnum::TABLE_ROUTE, DatabaseTableEnum::TABLE_ROUTE . '.id = ' . DatabaseTableEnum::TABLE_PAGE_ROUTE . '.routeID')
            ->where(array(
                'isDeleted' => self::STATUS_NOT_DELETED,
                'pageID'    => $page->id
            ))
            ->select(DatabaseTableEnum::TABLE_PAGE_ROUTE . '.*, ' . DatabaseTableEnum::TABLE_ROUTE . '.link')
            ->get(DatabaseTableEnum::TABLE_PAGE_ROUTE)
            ->result();
        foreach ($pageRoutes as $pageRoute) {
            $pageRoute->route = str_replace(self::TEMPLATE_ALIAS, $pageRoute->alias, $pageRoute->link);
            $pageRoute->route = site_url(str_replace(self::TEMPLATE_ALL, $pageRoute->alias, $pageRoute->route));
        }
        return $pageRoutes;
    }

    /**
     * @param $page
     * @return string
     */
    private function getDefaultPageRoute($page)
    {
        if (!isset($page->routes)) {
            $page->routes = $this->getPageRoutes($page);
        }
        if (!empty($page->routes)) {
            $pageRoute = reset($page->routes);
            return $pageRoute->route;
        }
        return base_url();
    }

    /**
     * @param $page
     * @return mixed
     */
    private function getPageCarcass($page)
    {
        $carcass = $this->getRecordByID(DatabaseTableEnum::TABLE_TEMPLATE, $page->templateCarcassID);
        return $carcass->alias;
    }

    /**
     * @param $page
     * @return mixed
     */
    private function getPageTemplate($page)
    {
        $template = $this->getRecordByID(DatabaseTableEnum::TABLE_TEMPLATE, $page->templateInnerID);
        return $template->alias;
    }

    /**
     * @param $number
     * @return mixed
     */
    public function getRecentPosts($number)
    {
        $pages = $this->db->where(array(
            'isDeleted'                                   => self::STATUS_NOT_DELETED,
            'isEnabled'                                   => self::STATUS_ENABLED,
            DatabaseTableEnum::TABLE_PAGE_TYPE . '.alias' => 'post'
        ))->limit($number)
            ->join(DatabaseTableEnum::TABLE_PAGE_TYPE, DatabaseTableEnum::TABLE_PAGE_TYPE . '.id = ' . DatabaseTableEnum::TABLE_PAGE . '.pageTypeID')
            ->order_by('id', 'desc')
            ->select(DatabaseTableEnum::TABLE_PAGE . '.*')
            ->get(DatabaseTableEnum::TABLE_PAGE)
            ->result();
        foreach ($pages as $page) {
            $this->loadPageMultilingualFields($page);
            $page->url = $this->getDefaultPageRoute($page);
        }
        return $pages;
    }

}