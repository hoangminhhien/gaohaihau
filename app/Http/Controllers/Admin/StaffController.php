<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    public function __construct(
        UserInterface $userModel
  ) {

        $this->userModel = $userModel;
    }
    public function index(Request $request){
        $input = $request->all();
        $request->flash();
        $staffLists = $this->userModel->getStaffList($input)->paginate(config('common.paginateLimit'));
        return view('admin.staffs.index', compact('staffLists'))->withInput($input);
    }

    public function store(StaffRequest $request ){
        $allParams = $request->all();
        $staff = $this->userModel->createStaff($allParams);
        return response()->json('success');
    }

    public function update(StaffRequest $request){
        $allParams = $request->all();
        $staff = $this->userModel->updateStaff($allParams);
        return response()->json('success');
    }
    public function delete($id){
        $staff = $this->userModel->delete($id);
        return response()->json(['result' => true]);
    }
}
