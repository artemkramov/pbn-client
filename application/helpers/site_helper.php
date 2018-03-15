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

/**
 * @param $string
 * @param bool $capitalizeFirstCharacter
 * @return mixed
 */
function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
{
    $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }
    return $str;
}