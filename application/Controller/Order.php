<?php 

namespace App\Controller;

use App\Exception\Order as OrderException;


class Order
{
    public function index()
    {
        $order_id = $this->get('order_id');

        if ($order_id < 1) {
            throw new OrderException('order_id不为空');
        }

        $info = ''; // 查数据库
        if (empty($info)) {
            throw new OrderException('订单数据不存在');
        }

        return array('list' => array(), 'total' => 12);
    }

    protected function get($name, $value = '')
    {
        if (isset($_GET[$name]) && $_GET[$name]) {
            return $_GET[$name];
        } else {
            return $value;
        }
    }
}
