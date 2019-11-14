<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class InventoryRequest extends FormRequest
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
        $rules = [
            'product_id' => 'required',
            'quantity' => 'required|numeric|max:99999999999',
            'price' => 'required|numeric|max:99999999999',
        ];

        return $rules;
    }

    public function messages(){
        return [
            'product_id.required' => trans('inventory.errors.product_id.required'),
            'quantity.required' => trans('inventory.errors.quantity.required'),
            'quantity.max' => trans('inventory.errors.quantity.max'),
            'price.required' => trans('inventory.errors.price.required'),
            'price.max' => trans('inventory.errors.price.max'),
        ];
    }
}
