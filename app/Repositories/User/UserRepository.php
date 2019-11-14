<?php
namespace App\Repositories\User;
use App\User;
use Repository;
use App\Repositories\User\UserInterface;
use Hash;

class UserRepository extends Repository implements UserInterface
{
    function __construct(User $userModel)
    {
        $this->model = $userModel;
    }

    public function getStaffList($input){
        $query = $this->model->select('*');
        if (!empty($input['name'])) {
            $query = $query->where('name', 'like' , '%'. $input['name'] .'%');
        }
        if (!empty($input['email'])) {
            $query = $query->where('email', 'like' ,'%'. $input['email'] .'%');
        }

        if (isset($input['role']) && $input['role'] != "ALL") {
            $query = $query->where('role', '=',$input['role']);
        }
            return $query;
    }

    public function createStaff($allParams){
        $staff = array();
        $staff['name'] = $allParams['name'];
        $staff['email'] = $allParams['email'];
        $staff['role'] = $allParams['role'];
        $staff['password'] = Hash::make($allParams['password']);
        $result = $this->create($staff);

        return $result;
    }

    public function updateStaff($allParams){
        $staff = array();
        $staff['id'] = $allParams['id'];
        $staff['name'] = $allParams['name'];
        $staff['email'] = $allParams['email'];
        if(!empty($allParams['password'])){
            $staff['password'] = Hash::make($allParams['password']);
        }
        $staff['role'] = $allParams['role'];
        $result = $this->model->where('id', $staff['id'])->update($staff);
        return $result;
    }
}