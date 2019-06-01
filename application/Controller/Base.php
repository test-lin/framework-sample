<?php 

namespace App\Controller;

use App\Common\Config;

class Base
{
    const SUCCESS = '200';
    const FAIL = '400';

    protected $configs;

    public function __construct()
    {
        $this->configs = Config::get();
    }

    protected function get($name, $value = '')
    {
        if (isset($_GET[$name]) && $_GET[$name]) {
            return $_GET[$name];
        } else {
            return $value;
        }
    }

    protected function responseSuccess($msg, $data = [])
    {
        $this->callbackAjax($msg, self::SUCCESS, $data);
    }

    protected function responseFail($msg, $data = [])
    {
        $this->callbackAjax($msg, self::FAIL, $data);
    }

    protected function responseOther($msg, $data = [], $code)
    {
        $this->callbackAjax($msg, $code, $data);
    }

    protected function callbackAjax($msg,$code, $result)
    {
        $json = array(
            'result'=> $result,
            'msg' => $msg,
            'status'=> $code
        );

        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options:nosniff;');

        exit(json_encode($json));
    }

    /**
     * 取文件地址
     *
     * @param string $path 存放路径
     * @param string $domain 访问域名
     * @return string
     */
    protected function getFilePath($path, $domain = '')
    {
        if($domain) {
            $imgDomain = $domain;
        } else {
            $imgDomain = isset($this->configs['project']['img_domain']) ? $this->configs['project']['img_domain'] : '';
        }

        $path = $path ? $path : '/common/default.jpg';

        return $imgDomain.'/'.trim($path,'/');
    }

    /**
     * 图片返回格式化
     *
     * @param string $path 图片路径
     * @return array|string
     */
    protected function getImageFormat($path)
    {
        $return = [];

        if ($path) {
            $return = array(
                'path' => $path,
                'url' => $this->getFilePath($path)
            );
        }

        return $return;
    }
}