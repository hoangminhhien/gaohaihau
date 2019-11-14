<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;
class RoomRequest extends FormRequest
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
            'project_code' => 'required|max:64',
            'building_code' => 'required|max:64',
        ];
        if(empty($input['room_no'])){
            $rules['room_no'] = 'required' ;
        }else{
            $room_no = $input['room_no'];
            foreach($room_no as $key => $rooms){
            $rules['room_no.'.$key] = 'required|unique:rooms,room_no,NULL,id,project_code,'.$input['project_code'].',building_code,'.$input['building_code'].',deleted_at,NULL';
            }
        }
        return $rules;
    }
}
