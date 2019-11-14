<?php
namespace App\Repositories\Order;

interface OrderInterface {
    public function updateOrder($data);
    public function getOrderById($id);
    public function getListOrder($input = []);
    public function createOrder($data);
    public function calcTotalOrderPrice($input = []);
}
