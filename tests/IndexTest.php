<?php

namespace Tests;

use App\Controller\Index;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @var Index
     */
    protected $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->controller = new Index();
    }

    public function testTest()
    {
        ob_start();
        $this->controller->test();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('这里是测试', $content);
    }

    public function testIndex()
    {
        ob_start();
        $this->controller->index();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('hello world!!!', $content);
    }

    /**
     * @dataProvider timeData
     * @throws \ReflectionException
     */
    public function testSetTime($param)
    {
        $method = new \ReflectionMethod('App\\Controller\\Index', 'setTime');
        // 将 run 方法从 private 变成类似于 public 的权限
        $method->setAccessible(true);

        // $param = '2019-03-18';
        $time = $method->invoke(new Index(), $param);

        $this->assertIsInt($time);

        $this->assertEquals(strtotime($param), $time);
    }

    public function timeData()
    {
        return [
            ['2019-03-18'],
            ['2000-02-18'],
            ['1996-10-20'],
        ];
    }
}
