<?php

class Menu extends Widget
{

    /**
     * @var string
     */
    public $type;

    /**
     * @return mixed
     * @throws Exception
     */
    public function widget()
    {
        if (empty($this->type)) {
            throw new Exception('Menu type is not set');
        }
        $links = $this->CI->menu_model->getMenuByType($this->type);

        return $this->CI->load->view('menu/' . $this->type, array(
            'links' => $links
        ));
    }

}