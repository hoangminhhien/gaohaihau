<?php

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rooms')->truncate();
        $json = File::get("database/data/rooms.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Room::create(array(
                'project_code' => $obj->project_code,
                'building_code' => $obj->building_code,
                'room_no' => $obj->room_no,
            ));
        }
    }
}
