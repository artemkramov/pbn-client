<?php

/**
 * Class Page
 */
class Page extends CI_Controller
{

    private $data;

    public function show()
    {
        $this->data['metaData'] = array();
        try {
            $uriString = $this->uri->uri_string();
            $page = $this->page_model->getPage($uriString);
            $this->prepareMetaData($page);
            $this->data['page'] = $page;
            if ($page->isPaginationOn) {
                $this->preparePagination($page);
            }

            $this->render('main');
        } catch (NotFoundException $ex) {
            $this->pageNotFound();
        }
    }

    public function pageNotFound()
    {
        $this->output->set_status_header(404);
        $page = new stdClass();
        $page->carcass = 'general-carcass';
        $page->template = '404';
        $this->data['page'] = $page;
        $this->data['title'] = 'Not found';
        $this->render('main');
    }

    private function render($template)
    {
        $this->load->view($template, $this->data);
    }

    private function prepareMetaData($page)
    {
        $this->data['title'] = $page->seoTitle;
        $this->data['metaData'] = array(
            'viewport'    => 'width=device-width, initial-scale=1, shrink-to-fit=no',
            'description' => $page->seoDescription,
            'keywords'    => $page->seoKeywords
        );
    }

    private function preparePagination($page)
    {
        $url = site_url($page->baseURI);
        $queryStringSegment = 'page';
        $pagination = $this->page_model->getRecordByID(DatabaseTableEnum::TABLE_PAGINATION, $page->paginationID);
        $isQueryPagination = strpos($pagination->template, '=') !== false;
        $prefix = !$isQueryPagination ? str_replace('<:page>', '', $pagination->template) : false;
        if ($isQueryPagination) {
            $queryStringSegment = explode('=', $pagination->template)[0];
        }
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
    }

}