<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderInterface;
use App\Repositories\User\UserInterface;
use Log;

class OrderController extends Controller
{
    public function __construct(
        OrderInterface $orderRepo,
        UserInterface $userRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
    }

    public function index(Request $request){
        $input = $request->input();
        $request->flash();
        if(empty($input['limit'])) {
            $input['limit'] = config('common.order.order_limit_selection.0');
        }
        $order_list = $this->orderRepo->getListOrder($input);
        $total_amount = $this->orderRepo->calcTotalOrderPrice($input);

        $shipper_list = $this->userRepo
            ->getStaffList([ 'role' => config('common.user.role.SHIPPER') ])
            ->get();

        return view('admin.orders.index', compact(
            'order_list',
            'shipper_list',
            'total_amount'
        ));
    }

    public function approve(Request $request) {
        $input = $request->input();
        $input['status'] = config('common.order.status.DELIVERED');
        $order_list = $this->orderRepo->updateOrderByIds($input, [
            'status' => config('common.order.status.ARCHIVED')
        ]);

        session(['submit_success' => 'approve']);
        return response()->json();
    }

    public function cancel_approve(Request $request) {
        $input = $request->input();
        $input['status'] = config('common.order.status.ARCHIVED');
        $order_list = $this->orderRepo->updateOrderByIds($input, [
            'status' => config('common.order.status.DELIVERED')
        ]);

        session(['submit_success' => 'cancel_approve']);
        return response()->json();
    }
}
