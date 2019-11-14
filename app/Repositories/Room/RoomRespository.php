<?php
namespace App\Repositories\Room;
use App\Models\Room;
use Repository;

class RoomRepository extends Repository implements RoomInterface
{
    function __construct(Room $roomModel)
    {
        $this->model = $roomModel;
    }

    public function getListRoom()
    {
    	$room = $this->model->select('project_code','building_code','room_no','remaining_rice')
                ->get();
        return $room;
    }
}