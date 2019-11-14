<?php
namespace App\Helpers;

class ViewHelper {
    public static function customerAddress($customer_data) {
        $address = '';
        if(empty($customer_data)) {
            return $address;
        }

        if(
            !empty($customer_data['project']) &&
            !empty($customer_data['building']) &&
            !empty($customer_data['room'])
        ) {
            $address = implode(', ', array(
                $customer_data['room']['room_no'],
                $customer_data['building']['name'],
                $customer_data['project']['name']
            ));
        } else if(!empty($customer_data['address'])) {
            $address = $customer_data['address'];
        }

        return $address;
    }
}