<?php 

namespace App\Common\Exception;

/**
 * 异常句柄（入口）类
 */
class Handler
{
    // 默认错误处理
    public static function errorHandler($errno, $errstr, $errfile = '', $errline = 0)
    {
        var_dump(func_get_args());
    }

    // 默认异常处理
    public static function exceptionHandler($ex)
    {
        try {
            throw $ex;
        } catch (\Exception $e) {
            echo "其他异常";
        }
    }

    // 致命错误处理
    public static function fatalErrorHandler()
    {
        if ($e = error_get_last()) {
            print_r($e);
        }
    }
}