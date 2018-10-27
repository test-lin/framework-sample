<?php 

namespace App\Exception;

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
        } catch (Order $e) {
            echo "订单异常";
            var_dump(get_class($e));
            echo '<pre>';
            print_r($e);
            // $return = array('status' => 1, 'message' => '系统繁忙，请稍后再试');
            // exit(json_encode($return));

        } catch (Goods $e) {
            echo "商品异常";
        } catch (User $e) {
            echo "用户异常";
        } catch (Exception $e) {
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