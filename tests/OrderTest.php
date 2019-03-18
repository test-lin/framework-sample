<?php
/**
 * ${doc}
 *
 * @author 梁子霖
 */

namespace Tests;

use App\Controller\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @var Order
     */
    protected $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->controller = new Order();
    }

    /**
     * @expectedException  \App\Exception\Order
     */
    public function testIndex()
    {
        $_GET['order_id'] = 1;

        $config = $this->controller->index();

        $this->assertIsArray($config);
    }
}
