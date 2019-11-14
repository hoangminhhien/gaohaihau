<?php
namespace App\Repositories\Building;
use App\Models\Building;
use Repository;

class BuildingRepository extends Repository implements BuildingInterface
{
    function __construct(Building $buildingModel)
    {
        $this->model = $buildingModel;
    }

    public function getListBuilding()
    {
        $buildings = $this->model->with('rooms')->get();
        return $buildings;
    }

}