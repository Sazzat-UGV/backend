<?php

use App\Models\EmailConfiguration;

if (!function_exists('Setting')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function Setting($name, $default = null)
    {
        return EmailConfiguration::getByName($name, $default);
    }
}
