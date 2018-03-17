<?php

/**
 * Class Breadcrumbs
 */
class Breadcrumbs extends Widget
{

    /**
     * @var array
     */
    public $links = array();

    /**
     * @var string
     */
    public $view = 'index';

    /**
     * @var bool
     */
    public $isMainPage = false;

    /**
     * @return mixed
     */
    public function widget()
    {
        $isHomeAvailable = false;
        foreach ($this->links as $link) {
            if ($link['url'] == base_url()) {
                $isHomeAvailable = true;
            }
        }
        if (!$isHomeAvailable) {
            $page = $this->CI->page_model->getMainPage();
            $this->CI->page_model->loadPageMultilingualFields($page);
            $this->links[] = array(
                'url'   => base_url(),
                'title' => $page->title
            );
        }
        $this->links = array_reverse(array_values($this->links));
        if ($this->isMainPage) {
            $this->links = array();
        }
        return $this->CI->load->view('breadcrumbs/' . $this->view, array(
            'links' => $this->links
        ), true);
    }


}