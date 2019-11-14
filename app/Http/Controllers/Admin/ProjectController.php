<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Building;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Log;
use DB;
use App\Repositories\project\ProjectInterface;
class ProjectController extends Controller
{
    public function __construct(ProjectInterface $project){
        $this->model = $project;
    }
    public function index(){
        $projects = $this->model->getListProject();
        return view('admin.projects.index', compact('projects'));
    }

    public function store(ProjectRequest $request){
        $data = $request->all();
        $project = $this->model->createProject($data);
        return redirect()->route('admin.projects.index');
    }
    public function update(ProjectRequest $request){
        $data = $request->all();
        $update = $this->model->updateProject($data);
        return redirect()->route('admin.projects.index');
    }

    public function delete($id){
        $project = Project::find($id);
        DB::beginTransaction();
        try {
            $project->buildings()->delete();
            $project->rooms()->delete();
            $project->delete();
            // all good
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return response()->json(['result' => true]);
    }

}
