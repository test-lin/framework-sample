<?php
/**
 * User: jani
 * Email: 505932384@qq.com
 * Date: 2019/6/1 0001 22:16
 */

namespace App\Common;


class Config
{
    static $config;

    public static function load($configPath)
    {
        self::$config = require $configPath;
    }

    public static function set($name, $values = null)
    {
        self::$config[$name] = $values;
    }

    public static function get($name = null, $default = null)
    {
        if ($name) {
            $return = self::$config[$name];
        } else {
            $return = self::$config;
        }

        return $return ?? $default;
    }
}