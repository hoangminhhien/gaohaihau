<?php

namespace App\Http\Requests;
use Illuminate\Http\Request as Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;

class StaffRequest extends FormRequest
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
           'name' => 'required|max:60',
           'email' =>'required|max:60|email|unique:users,email,NULL,id,deleted_at,NULL',
           'password' => 'required|min:6',
           'role' => Rule::in(config('common.role')),
        ];
        if(Auth::user()['role'] < $input['role']){
            return abort(403);
         }
        if($routesName == 'admin.staffs.update') {
            $role = DB::table('users')->where('id',$input['id'])->first();
              if(Auth::user()['role'] <= $role->role){
                return abort(403);
              }

            if(!empty($input['id'])){
                $rules['email'] = 'required|max:60|email|unique:users,email,'. $input['id'].',id,deleted_at,NULL';
            }
            if(!array_key_exists('password', $input)){
                $rules['password'] = '';
            }
        }
        return $rules;
    }
    public function messages() {
        return [
           'name.required' => trans('staff.error.name.required'),
           'name.max' => trans('staff.error.name.max'),
           'email.required' => trans('staff.error.email.required'),
           'email.max' => trans('staff.error.email.max'),
           'email.unique' => trans('staff.error.email.unique'),
           'email.email' => trans('staff.error.email.email'),
           'password.required' => trans('staff.error.password.required'),
           'password.min' => trans('staff.error.password.min'),
           'role.in' => trans('staff.error.role.in')
        ];
    }
}
