<?php

/**
 * Class Page
 */
class Page extends CI_Controller
{

    /**
     * Data which passed to view
     * @var array
     */
    private $data;

    public function __construct()
    {
        parent::__construct();

        $this->data['metaData'] = array();
        $this->data['linkData'] = array();
    }

    public function show()
    {
        try {

            /**
             * Try to fetch page
             */
            $uriString = $this->uri->uri_string();
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uriString .= '?' . $_SERVER['QUERY_STRING'];
            }
            $page = $this->page_model->getPage($uriString);

            /**
             * Load extra data for page if is necessary
             */
            $actionName = 'action' . ucfirst(dashesToCamelCase($page->alias));
            if (method_exists($this, $actionName)) {
                $this->{$actionName}($page);
            }

            /**
             * Prepare metadata
             */
            $this->prepareMetaData($page);
            $this->data['page'] = $page;

            /**
             * Prepare pagination if it's turned on
             * for the current page
             */
            if ($page->isPaginationOn) {
                $this->preparePagination($page);
            }

            /**
             * Render common view
             */
            $this->render('main');
        } catch (NotFoundException $ex) {
            $this->pageNotFound();
        }
    }

    /**
     * Not found handler
     */
    public function pageNotFound()
    {
        /**
         * Set http code as 404
         * and form error page via default template
         */
        $this->output->set_status_header(404);
        $page = new stdClass();
        $page->carcass = 'general-carcass';
        $page->template = '404';
        $this->data['page'] = $page;
        $this->data['title'] = 'Not found';
        $this->render('main');
    }

    /**
     * Render view by the given template
     * with collected data
     * @param $template
     */
    private function render($template)
    {
        $this->load->view($template, $this->data);
    }

    /**
     * Prepare metadata for the given page
     * @param $page
     */
    private function prepareMetaData($page)
    {
        $this->data['title'] = $page->seoTitle;
        $this->data['metaData'] = array(
            'viewport'    => 'width=device-width, initial-scale=1, shrink-to-fit=no',
            'description' => $page->seoDescription,
            'keywords'    => $page->seoKeywords
        );
        foreach ($page->extraMetadata as $meta) {
            $this->data['metaData'][$meta->name] = $meta->content;
        }
    }

    /**
     * Prepare pagination for the given page
     * @param $page
     */
    private function preparePagination($page)
    {
        /**
         * Generate base url for page
         */
        $url = site_url($page->baseURI);


        /**
         * GET parameter which corresponds to pagination number
         */
        $queryStringSegment = '';

        /**
         * Get pagination type for current page
         */
        $pagination = $this->page_model->getRecordByID(DatabaseTableEnum::TABLE_PAGINATION, $page->paginationID);

        /**
         * Check if pagination is made via GET parameter or URL segment
         */
        $isQueryPagination = strpos($pagination->template, '=') !== false;

        /**
         * Set prefix for pagination if pagination is set via URL segment
         * Like /page/2
         */
        $prefix = !$isQueryPagination ? str_replace('<:page>', '', $pagination->template) : false;
        if ($isQueryPagination) {
            $queryStringSegment = explode('=', $pagination->template)[0];
        }

        /**
         * Set configuration for pagination
         * Another part of configuration is located in application/config/pagination.php
         * All info about pagination settings is located there: https://www.codeigniter.com/userguide3/libraries/pagination.html
         */
        $config = array(
            'base_url'             => str_replace($this->config->item('url_suffix'), '', $url),
            'first_url'            => $url,
            'total_rows'           => $page->childrenCount,
            'per_page'             => $page->paginationPerPage,
            'uri_segment'          => $this->uri->total_segments(),
            'prefix'               => $prefix,
            'last_link'            => $page->childrenCount,
            'page_query_string'    => $isQueryPagination,
            'query_string_segment' => $queryStringSegment
        );
        $this->pagination->initialize($config);
        $page->paginationLinks = $this->pagination->create_links();
        if (isset($this->pagination->previousLink)) {
            $this->data['linkData'][] = array(
                'rel'  => 'prev',
                'href' => $this->pagination->previousLink
            );
        }
        if (isset($this->pagination->nextLink)) {
            $this->data['linkData'][] = array(
                'rel'  => 'next',
                'href' => $this->pagination->nextLink
            );
        }
    }

    /**
     * Form sitemap.xml
     */
    public function sitemap()
    {
        $pages = $this->page_model->getAllPagesForSitemapXml();
        ob_clean();
        header("Content-Type: text/xml;charset=utf-8");
        $this->load->view('sitemap', array(
            'pages' => $pages
        ));
    }

    /**
     * Sitemap html page
     */
    public function sitemapHtml()
    {
        /**
         * Set http code as 404
         * and form error page via default template
         */
        $this->output->set_status_header(404);
        $page = new stdClass();
        $page->carcass = 'general-carcass';
        $page->template = 'sitemap';
        $page->pages = $this->page_model->getPagesForSitemapHtml(10);
        $this->data['page'] = $page;
        $this->data['title'] = 'Sitemap';
        $this->render('main');
    }

}