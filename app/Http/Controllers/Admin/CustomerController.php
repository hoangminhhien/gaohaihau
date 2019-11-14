<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\CustomersRequest;
use App\Repositories\Customer\CustomerInterface;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Room\RoomInterface;
use App\Repositories\User\UserInterface;
use Lang;

class CustomerController extends Controller
{
    public function __construct(ProjectInterface $project,
        CustomerInterface $customer,
        BuildingInterface $building,
        ProductInterface $product,
        RoomInterface $room,
        OrderInterface $order,
        UserInterface $userRepo
    ) {
        $this->project = $project;
        $this->customer = $customer;
        $this->building = $building;
        $this->product = $product;
        $this->room = $room;
        $this->order = $order;
        $this->userRepo = $userRepo;;
    }
    public function index($project_code, $building_code, $room_no){
        $customers = $this->customer->getCustomerInfor(['project_code'=>$project_code, 'building_code'=>$building_code, 'room_no'=>$room_no]);
        $projects = $this->project->getProjectInfo(['project_code'=>$project_code]);
        return view('admin.customers.index', compact('customers', 'projects'));
    }

    public function update(CustomersRequest $request){
        $input = $request->all();
        $customers = $this->customer->update($input['id'],
            [
                'name' => $input['name'],
                'phone' => $input['phone'],
                'project_code' => $input['project_code'],
                'building_code' => $input['building_code'],
                'room_no' => $input['room_no'],
                'address' => $input['address'],
                'family_number_of_children' => $input['family_number_of_children'],
                'family_number_of_adults' => $input['family_number_of_adults'],
                'remaining_rice' => $input['remaining_rice']   
            ]);
        return response()->json('success');
    }

    public function delete($id){
        $this->customer->delete($id);
    }

    public function show($id){
        if(empty($input['customer_id'])){
            $input['customer_id'] = $id;
        }
        $orderLists = $this->order->getListOrder($input);
        $products = $this->customer->getUniqueProductOfOrder($orderLists);
        $customers = $this->customer->getCustomerInfor(['id' => $id]);
        // Data for detail
        $projects = $this->project->getListProject();
        $product_list = $this->product->getListProduct();
        $shipper_list = $this->userRepo
            ->getStaffList([ 'role' => config('common.user.role.SHIPPER') ])
            ->get();
        $units = Lang::get('common.products_unit_option');
        $gift_code = config('common.product.GIFT_CODE.NEWCUS.code');
        $promotion_products = $this->product->getListProductPromotion($gift_code);

        return view('admin.customers.show',
            compact(
                'orderLists',
                'products',
                'customers',
                'product_list',
                'projects',
                'shipper_list',
                'units',
                'promotion_products'
            )
        );
    }
}
