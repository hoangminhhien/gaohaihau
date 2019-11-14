<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Customer;
use Illuminate\Http\Request;
class CustomersRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required|max:256',
            'phone' => 'required|max:15|unique:customers,phone,' . $input['id'] . ',id,deleted_at,NULL',
            'project_code' => 'required',
            'building_code' => 'required',
            'room_no' => 'required',
            'address' => 'nullable'
        ];

        if (!empty($input['address'])) {
            $rules['project_code'] = 'nullable';
            $rules['building_code'] = 'nullable';
            $rules['room_no'] = 'nullable';
        }
        return $rules;
    }
    public function messages(){

        return[
            'name.required' => trans('customer.name_required'),
            'name.max' => trans('customer.name_max'),
            'phone.required' => trans('customer.phone_required'),
            'phone.max' => trans('customer.phone_max'),
            'phone.unique' => trans('customer.phone_unique'),
            'project_code.required' => trans('customer.request.project_code.required'),
            'building_code.required' => trans('customer.request.building_code.required'),
            'room_no.required' => trans('customer.request.room_no.required'),
        ];
    }
}
