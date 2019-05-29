<?php

namespace App\Common\Exception;

use Exception as BaseException;

class Exception extends BaseException
{
    public static function controllerNotFun($class_name)
    {
        return new self(sprintf(
            "%s 控制器不存在",
            $class_name
        ));
    }

    public static function functionNotFun($class_name, $fun_name)
    {
        return new self(sprintf(
            "%s@%s 方法不存在",
            $class_name,
            $fun_name
        ));
    }
}