<?php
/**
 * User: jani
 * Email: 505932384@qq.com
 * Date: 2019/6/1 0001 21:31
 */

return [
    'project' => [
        'img_domain' => 'http://static.test.me/'
    ],
    'db' => [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'test',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => 'root',
        // 数据库连接端口
        'hostport'    => '',
        // 数据库连接参数
        'params'      => [],
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
    ],
    'cache' => [
        'type'	=>	'redis',
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'expire'     => 0,
        'persistent' => false,
        'prefix'     => '',
    ],
    'log' => [
        // 日志记录方式，支持 file socket 或者自定义驱动类
        'type' => 'File',
        //日志保存目录
        'path' => '../data/log/',
        //单个日志文件的大小限制，超过后会自动记录到第二个文件
        'file_size' => 2097152,
        //日志的时间格式，默认是` c `
        'time_format' => 'c'
    ],
];