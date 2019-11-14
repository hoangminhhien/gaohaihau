<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\Customer\CustomerInterface;
use App\Repositories\Product\ProductInterface;
use Cookie;
use Log;
use App\Http\Requests\DeliveryRequest;
use App\Repositories\Order\OrderInterface;
use App\Repositories\OrderProduct\OrderProductInterface;
use NotificationHelper;

class OrderController extends Controller
{
    public function __construct(
        ProjectInterface $project,
        CustomerInterface $customer,
        ProductInterface $product,
        OrderInterface $order,
        OrderProductInterface $orderProduct
    ){
        $this->project = $project;
        $this->customer = $customer;
        $this->product = $product;
        $this->order = $order;
        $this->orderProduct = $orderProduct;
    }

    public function index(Request $request) {
        $order_cookie = json_decode($request->cookie('order'));
        $order_products = array();
        if(!empty($order_cookie)) {
            foreach ($order_cookie as $key => $value) {
                if(empty($value)) {
                    continue;
                }

                $product = $this->product->getProductByID($value->id);
                $product['quantity'] = $value->quantity;
                array_push($order_products, $product);
            }
        }
        $projects = $this->project->getListProject();
        $gift_code = config('common.product.GIFT_CODE.NEWCUS.code');
        $promotionProduct = $this->product->getListProductPromotion($gift_code);
        return view('web.orders.index', [
            'projects' => $projects,
            'order_products' => $order_products,
            'promotion_products' => $promotionProduct
        ]);
    }

    public function ajaxGetInforCustomerByPhone(Request $request){
        $customer = $this->customer->getCustomerUsingPhoneFirst($request->phone)->first();
        return response()->json($customer);
    }

    public function store(DeliveryRequest $request){
        $allParams = $request->all();
        $allParams['status'] = config('common.order.status.CUSTOMER_ORDER');
        $allParams['shipper_id'] = null;
        if(empty($allParams['customer_id'])){
            $allParams['gift_code'] = config('common.product.GIFT_CODE.NEWCUS.code');
        }

        // Create update or create customer
        $customer = $this->customer->createOrUpdateCustomer($allParams);
        $order = $allParams;
        $order['customer_id'] = $customer['id'];

        $result_order = $this->order->createOrder($order);

        $orderProduct = $allParams;
        $orderProduct['order_id'] =  $result_order['id'];
        $orderProduct['price'] = array();
        $product_list = $this->product->model->whereIn('id', $orderProduct['product_id'])->get();
        foreach ($product_list as $value) {
            $orderProduct['price'][$value['id']] = $value['price'];
        }

        $result_order_product = $this->orderProduct->createorUpdateOrderProduct($orderProduct);
        $db_data_column = [
            'id' =>  $result_order['id'],
            'status' => $result_order['status'],
        ];
        $data = $db_data_column;
        $order = $result_order;
        $data['order_table_view'] = view('admin.deliveries._customer_order_template', compact('order'))->render();
        NotificationHelper::pushNotification([
            'event' => 'customer_order',
            'data' => $data,
            'content_params' => [
                'name' => $allParams['name'],
                'phone' => $allParams['phone'],
            ],
            'db_data_column' => $db_data_column
        ]);
        return response()->json();
    }
}
