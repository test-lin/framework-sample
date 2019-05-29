<?php 

namespace App\Controller;

class Base
{
    protected function get($name, $value = '')
    {
        if (isset($_GET[$name]) && $_GET[$name]) {
            return $_GET[$name];
        } else {
            return $value;
        }
    }
}