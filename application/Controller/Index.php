<?php 

namespace App\Controller;

class Index
{
    public function index()
    {
        echo 'hello world!!!';
    }

    public function test()
    {
        echo '这里是测试';
    }

    private function setTime($time)
    {
        return strtotime($time);
    }
}