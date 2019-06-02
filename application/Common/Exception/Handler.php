<?php 

namespace App\Common\Exception;

use App\Common\Config;
use think\Log;

/**
 * 异常句柄（入口）类
 */
class Handler
{
    // 默认错误处理
    public static function errorHandler($errno, $errstr, $errfile = '', $errline = 0)
    {
        $log = (new Log());
        $log->init(Config::get('log'));

        $msg = "{$errno}: {$errstr} [{$errfile}:{$errline}]";

        echo $msg;

        $log->error($msg);
    }

    // 默认异常处理
    public static function exceptionHandler($ex)
    {
        $log = (new Log());
        $log->init(Config::get('log'));

        try {
            throw $ex;
        } catch (\Exception $e) {
            $msg = "{$e->getCode()}: {$e->getMessage()} [{$e->getFile()}:{$e->getLine()}]";

            echo $msg;

            $log->error($msg);
        }
    }

    // 致命错误处理
    public static function fatalErrorHandler()
    {
        $log = (new Log());
        $log->init(Config::get('log'));

        if ($e = error_get_last()) {
            $msg = "{$e['type']}: {$e['message']} [{$e['file']}:{$e['line']}]";

            echo $msg;

            $log->error($msg);
        }
    }
}