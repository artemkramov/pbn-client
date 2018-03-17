<?php

/**
 * Class Widget
 */
class Widget
{

    /**
     * @var mixed
     */
    protected $CI;

    /**
     * Load all configuration parameters
     * @param $config
     * @return Widget
     */
    public function init($config)
    {
        $this->CI =& get_instance();
        foreach ($config as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

}