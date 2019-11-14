<?php
namespace App\Repositories\Project;
use App\Models\Project;
use App\Models\Building;
use App\Models\Room;
use Repository;
class ProjectRepository extends Repository implements ProjectInterface
{
    function __construct(Project $projectModel)
    {
        $this->model = $projectModel;
    }

    public function getListProject(){
        $projectLists = $this->model->select('*')->paginate(config('common.project_limit'));
        return $projectLists;
    }
    public function createProject($data){
        $projects = array();
        $projects['project_code'] = $data['project_code'];
        $projects['name'] = $data['name'];
        $result = $this->create($projects);
        return $result;
    }
    public function updateProject($data){
        $projects = array();
        $projects['project_code'] = $data['project_code'];
        $projects['name'] = $data['name'];
        $result = $this->model->find($data['id'])->update($projects);
        return $result;
    }
    public function getProjectInfo(array $data){
        $customerList = $this->model->where($data)->first();
        return $customerList;
    }
}