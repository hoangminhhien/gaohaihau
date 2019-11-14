<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\CustomerInterface;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\Order\OrderInterface;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Room\RoomInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Issue\IssueInterface;
use Lang;
use CommonHelper;
use App\Http\Requests\CrmRequest;

class CrmController extends Controller
{
    public function __construct(
        ProjectInterface $project,
        CustomerInterface $customer,
        BuildingInterface $building,
        ProductInterface $product,
        RoomInterface $room,
        OrderInterface $order,
        UserInterface $userRepo,
        IssueInterface $issueRepo
    )
    {
        $this->project = $project;
        $this->customer = $customer;
        $this->building = $building;
        $this->product = $product;
        $this->room = $room;
        $this->order = $order;
        $this->userRepo = $userRepo;
        $this->issueRepo = $issueRepo;
    }

    public function index(){
        // Late order
        $input = [
            'status'=>config('common.issue.status.PENDING'),
            'type'=>config('common.issue.type.LATE'),
        ];
        $last_customer = $this->issueRepo->getIssueList($input);

        // New order
        $param = [
            'type' => config('common.issue.type.NEW'), 
            'status' => config('common.issue.status.PENDING')
        ];
        $getListNewCustomer = $this->issueRepo->getIssueList($param);

        // Get customer will out of rice
        $out_of_rice_input = array(
            'type' => config('common.issue.type.OUT_OF_RICE'),
            'status' => config('common.issue.status.PENDING'),
            'keep_collection' => true
        );
        $out_of_rices = $this->issueRepo
            ->getIssueList($out_of_rice_input)
            ->where('due_date', '<=',
                CommonHelper::getDate(
                    'Y-m-d H:i:s',
                    date('Y-m-d H:i:s'),
                    config('common.issue.OUT_OF_RICE_ALERT_BEFORE')
                )
            )
            ->paginate(config('common.limit'));

        // Get customer dont order 3 months
        $getListCustomerLate3Month = $this->issueRepo->getListCustomerLate3Month();

        // Data for detail
        $projects = $this->project->getListProject();
        $products = $this->product->getListProduct();
        $shipper_list = $this->userRepo
            ->getStaffList([ 'role' => config('common.user.role.SHIPPER') ])
            ->get();
        $units = Lang::get('common.products_unit_option');
        $gift_code = config('common.product.GIFT_CODE.NEWCUS.code');
        $promotion_products = $this->product->getListProductPromotion($gift_code);
        return view('admin.crm.index',compact(
            'getListNewCustomer',
            'customers',
            'products',
            'projects',
            'shipper_list',
            'units',
            'promotion_products',
            'last_customer',
            'out_of_rices',
            'getListCustomerLate3Month'
        ));
    }

    public function create(CrmRequest $request) {
        $input = $request->all();
        $this->issueRepo->createIssue($input);
        return response()->json();
    }

    public function update(CrmRequest $request, $id) {
        $input = $request->all();
        $this->issueRepo->updateIssue($id, $input);
        return response()->json();
    }
}
