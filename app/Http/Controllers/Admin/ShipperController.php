<?php 

namespace App\Http\Controllers\admin;

use App\Repositories\Project\ProjectInterface;
use App\Repositories\Customer\CustomerInterface;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Room\RoomInterface;
use App\Repositories\Order\OrderInterface;
use App\Repositories\OrderProduct\OrderProductInterface;
use App\Repositories\Issue\IssueInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\ShipperDeliveryRequest;
use App\Helpers\FileHelper;
use NotificationHelper;
use CommonHelper;
use DB;
use Log;

class ShipperController extends Controller
{
    public function __construct(
        ProjectInterface $project,
        CustomerInterface $customer,
        BuildingInterface $building,
        ProductInterface $product,
        RoomInterface $room,
        OrderInterface $order,
        OrderProductInterface $orderProduct,
        IssueInterface $issueRepo
  ) {

        $this->project = $project;
        $this->customer = $customer;
        $this->building = $building;
        $this->product = $product;
        $this->room = $room;
        $this->order = $order;
        $this->orderProduct = $orderProduct;
        $this->issueRepo = $issueRepo;
    }

    public function index(Request $request){
        $req = $request->all();
        $req['status'] = config('common.order.status.CONFIRMED');
        $req['shipper_id'] = Auth::id();
        $req['limit'] = config('common.orderLimit');
        $view = 'admin.shippers.index';

        if(!empty($req['history_tab'])) {
            $req['status'] = config('common.order.status.DELIVERED');

            if(empty($request['time'])) {
                $req['time'] = config('common.history_date_default_value');
            }

            if($req['time'] != 'ALL'){
                $req['delivered_time_from'] = CommonHelper::getDate('Y-m-d', date('Y-m-d'),$req['time'] );
                $req['delivered_time_to'] = date('Y-m-d');
            }
            if($req['time'] == config('common.history_date.MONTH_NOW')) {
                $req['delivered_time_from'] = date('Y-m-01');
                $req['delivered_time_to'] = date('Y-m-t');
            }
            $view = 'admin.shippers._history';
        }

        if(!empty($req['delivery_tab'])) {
            $view = 'admin.shippers._delivery';
        }

        $projects = $this->project->getListProject();
        $products = $this->product->getListProduct();
        $orders = $this->order->getListOrder($req);
        $total_products = $this->order->totalProduct($orders);

        return view($view, compact('products', 'projects', 'orders', 'total_products'));
    }

    public function delivery(ShipperDeliveryRequest $request, $id) {
        $input = $request->all();
        $delivery_image_url = null;
        // Upload image
        FileHelper::removeFileWithPrefix($base_path = config('common.upload_src.delivery_image'), $prefix = $id . '_');
        if (!empty($input['delivery_image_url'])) {
            $delivery_image_url = FileHelper::uploadFile($file = $input['delivery_image_url'], $id, $base_path = config('common.upload_src.delivery_image'));
        }

        // Get order info
        $order_info = $this->order->model
            ->where('shipper_id', Auth::user()->id)
            ->where('id', $id)
            ->where('status', config('common.order.status.CONFIRMED'))
            ->with('orderProduct.product', 'customer.room')
            ->first();
        if(!$order_info) {
            return response()->json();
        }

        $remaining_rice = 0;
        if(isset($input['remaining_rice_before_ship'])) {
            $remaining_rice += $input['remaining_rice_before_ship'];
        }

        foreach($order_info['orderProduct'] as $item) {
            if(!empty($item['product']['capacity'])) {
                $remaining_rice += $item['quantity'] * $item['product']['capacity'];
            }
        }
        $customer_info = $order_info->customer;
        // Update order_info
        DB::beginTransaction();
        try {
            $delivered_time = date('Y-m-d H:i:s');
            $order_info->update([
                'status' => config('common.order.status.DELIVERED'),
                'delivered_time' => $delivered_time,
                'delivery_image_url' => $delivery_image_url
            ]);
            // Update remaining rice
            if(!empty($customer_info)) {
                $this->customer->update(
                    $order_info['customer_id'], [
                    'remaining_rice' => $remaining_rice,
                ]);
            }

            // Create our of rice issue
            $this->issueRepo->createOutOfRiceIssue([
                'customer_id' => $order_info['customer_id'],
                'order_id' => $order_info['id']
            ]);

            // Create late customer
            if($delivered_time > $order_info->delivery_time_expect_to){
                $last_customer = $this->issueRepo->createNewIssues($order_info);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        $db_data_column = [
            'id' =>  $order_info['id'],
            'status' => config('common.order.status.DELIVERED'),
        ];
        $data = $db_data_column;
        $order = $order_info;
        $data['order_table_view'] = view('admin.deliveries._order_table_template', compact('order'))->render();
        NotificationHelper::pushNotification([
            'event' => 'delivered_order',
            'data' => $data,
            'content_params' => [
                'id' => $order_info['id'],
            ],
            'db_data_column' => $db_data_column
        ]);

        return response()->json();
    }
}
