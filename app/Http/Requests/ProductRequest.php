<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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
        return [
            'name' => 'required|max:256',
            'unit' => 'required',
            'capacity'=>'required',
            'price'=>'required',
            'short_desc'=>'required|max:200',
            'desc'=>'required|max:1000'
        ];
    }
    public function messages(){

        return[
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được vượt quá 256 kí tự',
            'capacity.required' => 'Khối lượng không được để trống',
            'price.required' => 'Giá không được để trống',
            'short_desc.required' => 'Mô tả ngắn không được để trống',
            'desc.required' => 'Mô tả không được để trống'
        ];
    }
}
