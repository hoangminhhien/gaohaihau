<?php
namespace App\Repositories\Order;
use App\Repositories\Product\ProductInterface;
use App\Models\Order;
use Repository;
use Log;
use Auth;

class OrderRepository extends Repository implements OrderInterface
{
    function __construct(Order $orderModel, ProductInterface $product)
    {
        $this->model = $orderModel;
        $this->product = $product;
    }

    public function getListOrder($input = []){
        $orderLists =$this->model->select('*')
                    ->with('orderProduct.product', 'customer.project', 'customer.building', 'customer.room', 'shipper')
                    ->orderBy('delivery_time_expect_to');

        $orderLists = $this->queryForGetListOrder($orderLists, $input);

        if(empty($input['not_paginate'])) {
            $limit = config('common.paginateLimitOrder');
            if(isset($input['limit'])) {
                $limit = $input['limit'];
            }
            $orderLists = $orderLists->paginate($limit);
        }
        return $orderLists;
    }
    public function createOrder($data){
        $order['customer_id'] = $data['customer_id'];
        if (!empty($data['gift_code'])) {
            $order['gift_code'] = $data['gift_code'];
        }
        if (!empty($data['delivery_time_expect_from'])) {
            $order['delivery_time_expect_from'] = date("Y-m-d H:i:00", strtotime(str_replace('/', '-', $data['delivery_time_expect_from'])));
        }

        if (!empty($data['delivery_time_expect_to'])) {
            $order['delivery_time_expect_to'] = date("Y-m-d H:i:00", strtotime(str_replace('/', '-', $data['delivery_time_expect_to'])));
        }

        $order['status'] = $data['status'];
        $order['shipper_id'] = $data['shipper_id'];
        $result = $this->model->create($order);
        return $result;
    }

    public function queryForGetListOrder($query, $input) {
        if(isset($input['status'])) {
            $query = $query->where('status', $input['status']);
        }

        if(isset($input['shipper_id']) && $input['shipper_id'] !== 'ALL') {
            $query = $query->where('shipper_id', $input['shipper_id']);
        }

        if(isset($input['delivery_time_expect_from'])) {
            $query = $query->where('delivery_time_expect_from', '>=',
                date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $input['delivery_time_expect_from'])))
            );
        }

        if(isset($input['delivery_time_expect_to'])) {
            $query = $query->where('delivery_time_expect_to', '<=',
                date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $input['delivery_time_expect_to'])))
            );
        }

        if(isset($input['delivered_time_from'])) {
            $query = $query->where('delivered_time', '>=',
                date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $input['delivered_time_from'])))
            );
        }

        if(isset($input['delivered_time_to'])) {
            $query = $query->where('delivered_time', '<=',
                date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $input['delivered_time_to'])))
            );
        }

        if(isset($input['id'])) {
            if(gettype($input['id']) == 'array') {
                $query = $query->whereIn('id', $input['id']);
            } else {
                $query = $query->where('id', $input['id']);
            }
        }

        if(isset($input['customer_id'])) {
            $query = $query->where('customer_id', $input['customer_id']);
        }

        return $query;
    }

    public function totalProduct($orders){
        $total_products = [];
        foreach ($orders as $order) {
            foreach ($order['orderProduct'] as $key => $orderProduct) {
               if (empty($total_products[$orderProduct['product_id']])) {
                    $total_products[$orderProduct['product_id']] = [
                        'quantity' => $orderProduct ['quantity'] ,
                        'name' => $orderProduct ['product']['name'],
                        'capacity' => $orderProduct ['product']['capacity'],
                    ];
                } else {
                    $total_products[$orderProduct['product_id']]['quantity'] += $orderProduct['quantity'];
                }
            }
        }
        return $total_products;
    }

    public function updateOrder($data){
        $order['status'] = $data['status'];
        if(isset($data['shipper_id'])){
            $order['shipper_id'] = $data['shipper_id'];
        }
        $id = $data['order_id'];
        if(isset($data['canceled_note'])){
            $order['canceled_note'] = $data['canceled_note'];
        }
        if(isset($data['delivered_time'])){
            $order['delivered_time'] = $data['delivered_time'];
        }
        if($data['status'] == config('common.order.status.CANCELED')){
            $this->updateProductQuantityCancel($id);
        }
        $result = $this->update($id, $order);;
        return $result;
    }

    public function getOrderById($id){
         $order =$this->model->select('*')
                    ->with('orderProduct.product', 'customer')
                    ->where('id', $id)
                    ->first();
        return $order;
    }

    public function calcTotalOrderPrice($input = []) {
        $orderLists =$this->model->select('*')
                    ->with('orderProduct.product');
        $orderLists = $this->queryForGetListOrder($orderLists, $input)->get();
        $total_amount = 0;

        foreach ($orderLists as $order_list_item) {
            foreach ($order_list_item['orderProduct'] as $item) {
                $total_amount += $item['price'] * $item['quantity'];
            }
        }

        return $total_amount;
    }

    public function updateOrderByIds($input, $data) {

        if(empty($input['all_id']) && empty($input['id'])) {
            return false;
        }

        $order_list = $this->model->select('*');
        $order_list = $this->queryForGetListOrder($order_list, $input);
        $order_list->update($data);
        return $order_list;
    }

    private function updateProductQuantityCancel($order_id){
        $order_products = $this->model->find($order_id)->orderProduct()->get();
        foreach ($order_products as $order_product) {
            $this->product->updateProductQuantity($order_product->product_id, $order_product->quantity);
        }
        return true;
    }
}