<?php
namespace App\Repositories\Customer;
use App\Models\Customer;
use Repository;

class CustomerRepository extends Repository implements CustomerInterface
{
    function __construct(Customer $customerModel)
    {
        $this->model = $customerModel;
    }

    public function getCustomer()
    {
    	$customerLists = $this->model->get();
        return $customerLists;
    }
    public function getCustomerInfor(array $data){
        $customerList = $this->model->where($data)->get();
        return $customerList;
    }
    public function getCustomerUsingPhone($data)
    {
        $customerLists = $this->model->with('project', 'building','room')
                    ->where('phone', 'like',  '%' . $data . '%')
                    ->orWhere('name', 'like', '%' . $data . '%')
                    ->limit(config('common.limitInfo'));
        return $customerLists;
    }

    public function createOrUpdateCustomer($allParams){
        $customer = array();
        $customer['name'] = $allParams['name'];
        $customer['phone'] = $allParams['phone'];
        $customer['project_code'] = $allParams['project_code'];
        $customer['building_code']= $allParams['building_code'];
        $customer['room_no']= $allParams['room_no'];
        $customer['address']= $allParams['address_kh'];
        if(isset($allParams['family_number_of_adults'])) {
            $customer['family_number_of_adults']= $allParams['family_number_of_adults'];
        }
        if(isset($allParams['family_number_of_children'])) {
            $customer['family_number_of_children']= $allParams['family_number_of_children'];
        }
        if(isset($allParams['remaining_rice'])) {
            $customer['remaining_rice']= $allParams['remaining_rice'];
        }
        if(empty($allParams['customer_id'])){
            $customer['gift_status'] = config('common.customer.GIFT_STATUS');
            $result = $this->create($customer);
        }else{
            $customer_update = $this->update($allParams['customer_id'], $customer);
            if($customer_update == 1){
                $result = $customer;
                $result['id'] = $allParams['customer_id'];
            }
        }
        return $result;
    }

    public function getCustomerUsingPhoneFirst($phone)
    {
        $customerLists = $this->model->with('project', 'building','room')
                    ->where('phone', $phone );
        return $customerLists;
    }

    public function getUniqueProductOfOrder($data){
        $product = array();
        foreach ($data as $value) {
            foreach ($value['orderProduct'] as $val) {
                if(!array_key_exists($val['product_id'], $product)){
                    $product[$val['product_id']] = $val['product'];
                }
            }
        }
        return $product;
    }
}