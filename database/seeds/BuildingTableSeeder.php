<?php

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('buildings')->truncate();
       	$json = File::get("database/data/buildings.json");
       	$data = json_decode($json);
       	foreach ($data as $obj) {
           	Building::create(array(
               'name' => $obj->name,
               'project_code' => $obj->project_code,
               'building_code' => $obj->building_code
           ));
       }

    }
}
