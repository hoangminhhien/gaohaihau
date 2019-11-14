<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CrmRequest extends FormRequest
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
        $rules = [
            'customer_id' => 'required|max:99999999999',
            'type' => Rule::in(config('common.issue.type'))
        ];

        if($routesName == 'admin.crm.update') {
            $rules['customer_id'] = '';
            $rules['due_date'] = 'nullable|date';
            $rules['type'] = ['nullable', Rule::in(config('common.issue.type'))];
            $rules['status'] = ['nullable', Rule::in(config('common.issue.status'))];
        }
        return $rules;
    }
}
