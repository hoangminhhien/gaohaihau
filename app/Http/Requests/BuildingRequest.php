<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Building;
use Illuminate\Http\Request;
class BuildingRequest extends FormRequest
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
        // dd($input);
        $rules = [
            'project_code' => 'required|max:64',
            'building_code' => 'required|max:64|unique:buildings,building_code,NULL,id,project_code,'.$input['project_code'].',deleted_at,NULL',
            'building_name' => 'required|max:256'
        ];
        if(!empty($input['id'])){
            $rules['building_code'] = 'required|max:64|unique:buildings,building_code,'. $input['id'] . ',id,project_code,'.$input['project_code'].',deleted_at,NULL';
                }
        return $rules;
    }
}
