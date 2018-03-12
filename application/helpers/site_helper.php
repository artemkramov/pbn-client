<?php

// Get a reference to the controller object
$CI = get_instance();

/**
 * @param $number
 * @return mixed
 */
function getRecentPosts($number)
{
    global $CI;
    return $CI->page_model->getRecentPosts($number);
}