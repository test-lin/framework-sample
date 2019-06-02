<?php
/**
 * User: jani
 * Email: 505932384@qq.com
 * Date: 2019/6/1 0001 21:50
 */

use App\Common\Exception\Exception;
use App\Common\Config;
use think\Db;
use think\Cache;

class bootstrap
{
    public function __construct()
    {
        $this->config();

        $this->func();

        $this->exceptionHandler();

        $this->db();

        $this->cache();
    }

    private function config()
    {
        Config::load(__DIR__ . '/../data/config.php');
    }

    private function exceptionHandler()
    {
        // 项目异常处理
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        register_shutdown_function(array('App\\Common\\Exception\\Handler', 'fatalErrorHandler'));
        set_error_handler(array('App\\Common\\Exception\\Handler', 'errorHandler'));
        set_exception_handler(array('App\\Common\\Exception\\Handler', 'exceptionHandler'));
    }

    private function func()
    {
        require __DIR__ . '/../application/Common/function.php';
    }

    private function db()
    {
        Db::setConfig(Config::get('db'));
    }

    private function cache()
    {
        Cache::init(Config::get('cache'));
    }

    public function run()
    {
        $act = (isset($_GET['act']) && $_GET['act']) ? $_GET['act'] : 'Index';
        $act = $_GET['act'] = ucwords(strtolower($act));
        $op = $_GET['op'] = (isset($_GET['op']) && $_GET['op']) ? $_GET['op'] : 'index';

        $class_name = "App\\Controller\\{$act}";
        if (class_exists($class_name) === false) {
            throw Exception::controllerNotFun($class_name);
        } elseif (method_exists($class_name, $op) === false) {
            throw Exception::functionNotFun($class_name, $op);
        }

        $controller = new $class_name();

        $controller->$op();
    }
}

return (new bootstrap());
