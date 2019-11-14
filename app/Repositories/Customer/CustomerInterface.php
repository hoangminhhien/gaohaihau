<?php
namespace App\Repositories\Customer;

interface CustomerInterface {
    public function getUniqueProductOfOrder($data);
    public function getCustomer();
    public function getCustomerInfor(array $data);
    public function getCustomerUsingPhone($phone);
    public function createOrUpdateCustomer($allParams);
    public function getCustomerUsingPhoneFirst($allParams);
}
