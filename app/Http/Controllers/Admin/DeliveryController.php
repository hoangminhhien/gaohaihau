<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\Customer\CustomerInterface;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Room\RoomInterface;
use App\Repositories\Order\OrderInterface;
use App\Repositories\OrderProduct\OrderProductInterface;
use App\Http\Requests\DeliveryRequest;
use App\Repositories\User\UserInterface;
use App\Repositories\Issue\IssueInterface;
use App\Models\Order;
use Log;
use Lang;
use NotificationHelper;

class DeliveryController extends Controller
{
    public function __construct(
        ProjectInterface $project,
        CustomerInterface $customer,
        BuildingInterface $building,
        ProductInterface $product,
        RoomInterface $room,
        OrderInterface $order,
        OrderProductInterface $orderProduct,
        UserInterface $userRepo,
        IssueInterface $issueRepo
    ) {
        $this->project = $project;
        $this->customer = $customer;
        $this->building = $building;
        $this->product = $product;
        $this->room = $room;
        $this->order = $order;
        $this->orderProduct = $orderProduct;
        $this->userRepo = $userRepo;
        $this->issueRepo = $issueRepo;
    }

    public function index(){
        $input['not_paginate'] = true;
        $input_order = $input_customer_order = $input_delivered_order = $input;

        $projects = $this->project->getListProject();
        $products = $this->product->getListProduct();

        $input_order['status'] = config('common.order.status.CONFIRMED');
        $orders = $this->order->getListOrder($input_order)
        ->paginate(config('common.paginateLimitOrder'), ['*'], 'o'. $input_order['status']);

        $input_customer_order['status'] = config('common.order.status.CUSTOMER_ORDER');
        $customer_orders = $this->order->getListOrder($input_customer_order)
            ->paginate(config('common.paginateLimitOrder'), ['*'], 'o'. $input_customer_order['status']);

        // Get delivered order
        $input_delivered_order['status'] = config('common.order.status.DELIVERED');
        $delivered_orders = $this->order->getListOrder($input_delivered_order)
            ->paginate(config('common.paginateLimitOrder'), ['*'], 'o'. $input_delivered_order['status']);

        //shipper
        $shipper_list = $this->userRepo
            ->getStaffList([ 'role' => config('common.user.role.SHIPPER') ])
            ->get();
        $units = Lang::get('common.products_unit_option');

        // promotion product
        $gift_code = config('common.product.GIFT_CODE.NEWCUS.code');
        $promotionProduct = $this->product->getListProductPromotion($gift_code);

        return view('admin.deliveries.index', [
            'products' =>$products,
            'projects' => $projects,
            'orders' => $orders,
            'customer_orders' => $customer_orders,
            'shipper_list' => $shipper_list,
            'units' => $units,
            'delivered_orders' => $delivered_orders,
            'promotion_products' => $promotionProduct
        ]);
    }

    public function store(DeliveryRequest $request)
    {
        $allParams = $request->all();
        $input = [];
        if(empty($allParams['customer_id'])){
            $allParams['gift_code'] = config('common.product.GIFT_CODE.NEWCUS.code');
        }
        $customer = $this->customer->createOrUpdateCustomer($allParams);

        $order = $allParams;
        $order['customer_id'] = $customer['id'];
        $order['status'] = config('common.order.status.CONFIRMED');
        $result_order = $this->order->createOrder($order);

        //update Issue
        if(!empty($allParams['issue_id'])){
            $input['status'] = config('common.issue.status.RESOLVE');
            $this->issueRepo->updateIssue($allParams['issue_id'], $input);
        }

        $orderProduct = $allParams;
        $orderProduct['order_id'] =  $result_order['id'];

        //get list issue new customer
        $issue_customer = [
            'customer_id' =>  $order['customer_id'],
            'order_id' =>  $orderProduct['order_id'],
        ];
        $issueCustomer = $this->issueRepo->createNewCustomer($issue_customer);
        $result_order_product = $this->orderProduct->createorUpdateOrderProduct($orderProduct);

        // Push notification confirmed
        if($order['status'] == config('common.order.status.CONFIRMED')) {
            $result_order['name'] = $allParams['name'];
            $result_order['phone'] = $allParams['phone'];
            $result_order['order_id'] = $result_order['id'];
            $this->pushNotificationAfterConfirmOrder($result_order);
        }

        return response()->json(['success'=>trans('delivery.success')]);
    }

    public function ajaxGetInforCustomer(Request $request)
    {
        $customer = $this->customer->getCustomerUsingPhone($request->data)->get();
        return response()->json($customer);
    }

    public function edit (Request $request){
        $order = $this->order->getOrderById($request->id);
        return response()->json($order);
    }

    public function show (Request $request){
        $order = $this->order->getOrderById($request->id);
        return response()->json($order);
    }

    public function update($status, DeliveryRequest $request){
        $allParams = $request->all();
        $CONFIRMED_STATUS = config('common.order.status.CONFIRMED');
        $DELIVERED_STATUS = config('common.order.status.DELIVERED');
        if(in_array($status, [$CONFIRMED_STATUS, $DELIVERED_STATUS])){
            // Get order info
            $order_info = $this->order->model
                ->where('id', $allParams['order_id'])
                ->with('orderProduct.product', 'customer.room')
                ->first();

            // Calc remaining rice
            if($status == $DELIVERED_STATUS) {
                if(!isset($allParams['remaining_rice'])) {
                    $allParams['remaining_rice'] = 0;
                }
                foreach($order_info['orderProduct'] as $item) {
                    if(!empty($item['product']['capacity'])) {
                        $allParams['remaining_rice'] += $item['quantity'] * $item['product']['capacity'];
                    }
                }
                $allParams['delivered_time'] = date('Y-m-d H:i:s');
            }

            $customer = $this->customer->createOrUpdateCustomer($allParams);
            $orderProduct = $allParams;

            //get list issue new customer
            $issue_customer = [
                'customer_id' =>  $allParams['customer_id'],
                'order_id' =>  $allParams['order_id'],
            ];
            $issueCustomer = $this->issueRepo->createNewCustomer($issue_customer);
            $result_order = $this->orderProduct->createOrUpdateOrderProduct($orderProduct);
        }

        $order = $allParams;
        $order['status'] = $status;
        $result_order = $this->order->updateOrder($order);

        // Push notification confirmed
        if($order['status'] == $CONFIRMED_STATUS) {
            $this->pushNotificationAfterConfirmOrder($order);
        }
        return response()->json(['success' => trans('delivery.modal.success')]);
    }

    public function cancel($status,Request $request){
        $allParams = $request->all();
        $order = $allParams;
        $order['status'] = $status;
        $result_order = $this->order->updateOrder($order);

        // Push notification when cancel
        $this->pushNotificationAfterCancelOrder($order);

        return response()->json(['success' => trans('delivery.modal.success')]);
    }

    function pushNotificationAfterConfirmOrder($order) {
        // Push to shipper
        $input = array();
        $input['status'] = config('common.order.status.CONFIRMED');
        $input['shipper_id'] = $order['shipper_id'];
        $input['not_paginate'] = true;
        $order_list = $this->order->getListOrder($input)->get();
        $total_products = $this->order->totalProduct($order_list);

        $orders = array();
        foreach ($order_list as $item) {
            if($item['id'] == $order['order_id']) {
                $orders = array($item);
                break;
            }
        }

        $db_data_column = [
            'id' =>  $order['order_id'],
            'status' => $order['status']
        ];
        $data = $db_data_column;

        $data['order_view'] = view('admin.shippers._order_template', compact('orders'))->render();
        $data['remaining_total_view'] = view('admin.shippers._remaining_total_template', compact('total_products'))->render();

        NotificationHelper::pushNotification([
            'event' => 'confirmed_order_to_shipper',
            'data' => $data,
            'content_params' => [
                'name' => $order['name'],
                'phone' => $order['phone'],
                'delivery_time_expect_from' => date('H:i d/m/Y', strtotime($order['delivery_time_expect_from'])),
                'delivery_time_expect_to' => date('H:i d/m/Y', strtotime($order['delivery_time_expect_to'])),
            ],
            'to_condition' => [ 'id' => $order['shipper_id'] ],
            'db_data_column' => $db_data_column
        ]);
    }

    function pushNotificationAfterCancelOrder($order) {
        // Push to shipper
        $order_info = $this->order->model->find($order['order_id'])->first();
        if(!$order_info) {
            return false;
        }

        $input = array();
        $input['status'] = config('common.order.status.CONFIRMED');
        $input['shipper_id'] =  $order_info['shipper_id'];
        $input['not_paginate'] = true;

        $order_list = $this->order->getListOrder($input)->get();
        $total_products = $this->order->totalProduct($order_list);

        $db_data_column = [
            'id' =>  $order['order_id'],
            'status' => $order['status']
        ];
        $data = $db_data_column;

        $data['remaining_total_view'] = view('admin.shippers._remaining_total_template', compact('total_products'))->render();

        NotificationHelper::pushNotification([
            'event' => 'canceled_order',
            'data' => $data,
            'content_params' => [ 'id' =>  $order_info['id']],
            'to_condition' => [ 'id' =>  $order_info['shipper_id'] ],
            'db_data_column' => $db_data_column
        ]);
    }

    public function approveList(Request $request) {
        $input = $request->all();
        $result_order = $this->order->update($input['id'], [
            'status' => config('common.order.status.ARCHIVED')
        ]);
        return response()->json();
    }

}
