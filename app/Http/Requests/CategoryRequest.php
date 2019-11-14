<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as Request;

class CategoryRequest extends FormRequest
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
        $rules = [
           'name' => 'required|max:64',
           'slug' => 'required|max:64',
        ];
        return $rules;
    }
    public function messages() {
        return [
           'name.required' => trans('categories.name_error.required'),
           'name.max' => trans('categories.name_error.max'),
           'slug.required' => trans('categories.slug_error.required'),
           'slug.max' => trans('categories.slug_error.max'),
        ];
    }
}
