<?php
namespace App\Repositories\Project;

interface ProjectInterface
{
    public function getListProject();
    public function createProject($data);
    public function updateProject($data);
    public function getProjectInfo(array $data);
}