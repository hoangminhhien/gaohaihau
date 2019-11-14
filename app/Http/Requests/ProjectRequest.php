<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectRequest extends FormRequest
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
        $input = Request::all();
        // create
        $rules = [
            'name'=>'required',
            'project_code'=>'required|unique:projects,project_code,NULL,id,deleted_at,NULL',
        ];

        // Update 
        if(!empty($input['id'])){
            $rules['project_code'] = 'required|unique:projects,project_code,' . $input['id'] . ',id,deleted_at,NULL';
        }
        return $rules;
    }
    public function messages(){
        return [
            'name.required' => trans('project.messages_required_name'),
            'project_code.required' => trans('project.messages_required_code'),
            'project_code.unique' => trans('project.messages_unique_code'),
        ];
    }
}
