<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Log;

class DeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $routesName = Request::route()->getName();
        $input = Request::all();
        $rules = [
            'name' => 'required|max:256',
            'phone' => 'required|numeric|max:99999999999999|unique:customers,phone,NULL,id,deleted_at,NULL',
            'project_code' => 'required',
            'building_code' => 'required',
            'room_no' => 'required',
            'product_id' => 'required|array',
            'address_kh' => 'nullable',
            'family_number_of_adults' => 'nullable|numeric|max:99999999999',
            'family_number_of_children' => 'nullable|numeric|max:99999999999',
            'remaining_rice' => 'nullable|numeric|max:99999999999',
        ];

        // Lay ngay bat dau
        if(!empty($input['delivery_time_expect_from'])){
            $start_date = $input['delivery_time_expect_from'];
            $rules['delivery_time_expect_to'] = 'after:' .$start_date;
        }

        if(!empty($input['customer_id'])){
            $rules['phone'] = 'required|numeric|max:99999999999|unique:customers,phone,'. $input['customer_id'].',id,deleted_at,NULL';
        }

        if (!empty($input['address_kh'])) {
            $rules['project_code'] = 'nullable';
            $rules['building_code'] = 'nullable';
            $rules['room_no'] = 'nullable';
        }
        return $rules;
    }
    public function messages(){

        return[
            'name.required' => trans('delivery.request.name.required'),
            'name.max' => trans('delivery.request.name.max'),
            'phone.required' => trans('delivery.request.phone.required'),
            'phone.numeric' => trans('delivery.request.phone.numeric'),
            'phone.max' => trans('delivery.request.phone.max'),
            'phone.unique' => trans('delivery.request.phone.unique'),
            'product_id.required' => trans('delivery.request.product_id.required'),
            'product_id.array' => trans('delivery.request.product_id.array'),
            'project_code.required' => trans('delivery.request.project_code.required'),
            'building_code.required' => trans('delivery.request.building_code.required'),
            'room_no.required' => trans('delivery.request.room_no.required'),
            'delivery_time_expect_to.after' => trans('delivery.request.delivery_time_expect_to.after'),
        ];
    }
}
