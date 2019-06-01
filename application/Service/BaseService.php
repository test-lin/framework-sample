<?php
/**
 * User: jani
 * Email: 505932384@qq.com
 * Date: 2019/6/1 0001 21:16
 */

namespace App\Service;


use App\Common\Config;

class BaseService
{
    protected $config;

    public function __construct()
    {
        $this->config = Config::get();
    }
}