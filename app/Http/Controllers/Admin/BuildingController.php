<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Project;
use App\Models\Room;
use App\Http\Requests\BuildingRequest;
use App\Http\Requests\RoomRequest;
use App\Repositories\Customer\CustomerInterface;
use DB;
class BuildingController extends Controller
{
    public function __construct(CustomerInterface $customer) {
        $this->customer= $customer;
    }

    public function index($project_code){
        $customer = $this->customer->all();
        $project = Project::where('project_code',$project_code)->first();
        $buildings = Building::with('rooms.customers')->where('project_code',$project_code)->get();
        return view('admin.buildings.index', [
            'project' => $project,
            'buildings' => $buildings,
        ]);
    }

    public function edit_building(BuildingRequest $request){
        $input = $request->all();
        // Create or update building
        Building::updateOrCreate(
            [
                'project_code' => $input['project_code'],
                'building_code'=> $input['building_code']
            ],
            [
                'project_code' => $input['project_code'],
                'building_code'=> $input['building_code'],
                'name'=> $input['building_name']
            ]
        );
        //crete room
        Room::where('project_code', $input['project_code'])->where('building_code', $input['building_code'])->forcedelete();
        if(!empty($input['room_no'])){
            foreach($input['room_no'] as $rooms){
                Room::insert([
                    'project_code' => $input['project_code'],
                    'building_code' => $input['building_code'],
                    'room_no' => $rooms,
                ]);
            }
        }

        return redirect()->route('admin.building.index',$input['project_code']);
    }

    public function delete_building($id){
        $building = Building::find($id);
        DB::beginTransaction();
        try {
            Building::where('id',$id)->delete();
            $building->rooms()->delete();
            // all good
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
