<?php
namespace App\Repositories\Issue;
use App\Models\Issue;
use App\Repositories\Customer\CustomerInterface;
use App\Models\Customer;
use CommonHelper;
use Repository;
use Log;
use App\Repositories\Order\OrderInterface;

class IssueRepository extends Repository implements IssueInterface
{
    function __construct(
        Issue $issueModel,
        Customer $customer,
        CustomerInterface $customerRepo,
        OrderInterface $orderRepo
    )
    {
        $this->model = $issueModel;
        $this->customer = $customer;
        $this->customerRepo = $customerRepo;
        $this->orderRepo = $orderRepo;
    }

    public function getIssueList($input = []) {
        $issue_list = null;
        $issue_query = $this->model->select('*');

        if(isset($input['type'])) {
            $issue_query = $issue_query->where('type', $input['type']);
        }

        if(isset($input['status'])) {
            $issue_query = $issue_query->where('status', $input['status']);
        }

        $issue_list = $issue_query->with(
            'customer.project',
            'customer.building',
            'customer.room',
            'order.shipper'
        );

        if(empty($input['keep_collection'])) {
            $issue_list = $issue_list->paginate(config('common.limit'));
        }

        return $issue_list;
    }

    public function getListCustomerLate3Month(){
        $month = CommonHelper::getDate('Y/m/d',now(),'-3 months');
        $last_order_raw = '(
            SELECT
                MAX(created_at) as created_at,
                MAX(deleted_at) as deleted_at,
                customer_id,
                MAX(id) as id
            FROM orders
            WHERE deleted_at is null
            GROUP BY customer_id
        ) AS orders';

        $customer = $this->orderRepo->model->select('*')
            ->from(\DB::raw($last_order_raw))
            ->with(
                'customer.project',
                'customer.building',
                'customer.room',
                'orderProduct.product'
            )
            ->with(['customer.customer_issue' => function($query){
                $query->where('issues.status', '<>', config('common.issue.status.CANCEL'))
                    ->where('issues.type', config('common.issue.type.NO_ORDER_3_MONTH'));
            }])
            ->where('created_at', '<' ,$month)
            ->paginate(config('common.limit'));
        return $customer;
    }

    public function createNewCustomer($input) {
        $data = [];
        $data['type'] = config('common.issue.type.NEW');
        $data['due_date'] = CommonHelper::getDate('Y-m-d H:i:s', date('Y-m-d H:i:s'),config('common.issue.DUE_DATE_NEW_CUSTOMER'));
        $data['customer_id'] = $input['customer_id'];
        $data['order_id'] = $input['order_id'];
        $result = $this->model->create($data);
        return $result;
    }

    public function createOutOfRiceIssue($input = []) {
        if(empty($input['customer_id'])){
            return false;
        }
        $due_date = $this->getOutOfRiceDate($input['customer_id']);
        if(!$due_date) {
            return false;
        }

        // Update old issue
        $issue_info = $this->model
            ->where('type', config('common.issue.type.OUT_OF_RICE'))
            ->where('status', config('common.issue.status.PENDING'))
            ->where('customer_id', $input['customer_id'])
            ->first();
        if($issue_info) {
            $issue_info['status'] = config('common.issue.status.CANCEL');
            $issue_info->save();
        }

        // Create issue
        $issue_info = $this->create([
            'customer_id' => $input['customer_id'],
            'due_date' => $due_date,
            'type' => config('common.issue.type.OUT_OF_RICE'),
            'order_id' => $input['order_id'],
        ]);

        return $issue_info;
    }

    function getOutOfRiceDate($customer_id) {
        $customer_info = $this->customerRepo
            ->model
            ->where('id', $customer_id)
            ->with('room')
            ->first();

        if(!$customer_info) {
            return false;
        }
        $adult = config('common.issue.default_adult_num');
        $child = config('common.issue.default_child_num');
        $meal_in_day = config('common.issue.meal_in_day');
        $remaining_rice = 0;
        $adult_eat_rice = config('common.issue.adult_eat_rice');
        $child_eat_rice = config('common.issue.child_eat_rice');

        if(!empty($customer_info['family_number_of_adults'])) {
            $adult = $customer_info['family_number_of_adults'];
        }
        if(!empty($customer_info['family_number_of_children'])) {
            $child = $customer_info['family_number_of_children'];
        }
        if(!empty($customer_info['remaining_rice'])) {
            $remaining_rice = $customer_info['remaining_rice'];
        }
        $remaining_days = floor(
            $remaining_rice /
            ($meal_in_day * ($adult * $adult_eat_rice + $child * $child_eat_rice))
        );
        $due_date = CommonHelper::getDate(
            'Y-m-d H:i:s',
            date('Y-m-d H:i:s'),
            '+' . $remaining_days . ' days'
        );
        return $due_date;
    }

    public function createNewIssues($input) {
        $data = [];
        $data['customer_id'] = $input['customer_id'];
        $data['type'] = config('common.issue.type.LATE');
        $data['status'] = config('common.issue.status.PENDING');
        $data['due_date'] = CommonHelper::getDate('Y-m-d H:i:s', date('Y-m-d H:i:s'),config('common.issue.DUE_DATE_DELAY_ORDER'));
        $data['order_id'] = $input['id'];
        $result = $this->model->create($data);
        return $result;
    }

    public function updateIssue($id = null, $input = []) {
        $data = [];
        if(isset($input['type'])) {
            $data['type'] = $input['type'];
        }

        if(isset($input['status'])) {
            $data['status'] = $input['status'];
        }

        if(isset($input['due_date'])) {
            $data['due_date'] = $input['due_date'];
        }

        $result = $this->update($id, $data);
        return $result;
    }

    public function createIssue($input = []) {
        $data = [
            'customer_id' => $input['customer_id'],
            'type' => $input['type']
        ];

        if(empty($input['due_date'])) {
            $data['due_date'] = CommonHelper::getDate('Y-m-d H:i:s', date('Y-m-d H:i:s'),config('common.issue.DEFAULT_DUE_DATE'));
        }

        if(!empty($input['order_id'])) {
            $data['order_id'] = $input['order_id'];
        }
        $result = $this->model->create($data);
        return $result;
    }
}