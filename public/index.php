<?php 

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../application/Common/function.php';

use App\Common\Exception\Exception;

// 项目异常处理
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
register_shutdown_function(array('App\\Exception\\Handler', 'fatalErrorHandler'));
set_error_handler(array('App\\Exception\\Handler', 'errorHandler'));
set_exception_handler(array('App\\Exception\\Handler', 'exceptionHandler'));

$act = (isset($_GET['act']) && $_GET['act']) ? $_GET['act'] : 'Index';
$op = (isset($_GET['op']) && $_GET['op']) ? $_GET['op'] : 'index';

$class_name = "App\\Controller\\{$act}";

if (class_exists($class_name) === false) {
    throw Exception::controllerNotFun($class_name);
} elseif (method_exists($class_name, $op) === false) {
    throw Exception::functionNotFun($class_name, $op);
}

$controller = new $class_name();

$controller->$op();