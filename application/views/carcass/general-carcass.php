<?php

/**
 * @var stdClass $page
 */

$this->load->view('template/' . $page->template, array(
    'page' => $page
));

?>

