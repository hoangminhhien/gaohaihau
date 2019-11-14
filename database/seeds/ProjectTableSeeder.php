<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('projects')->truncate();
        $json = File::get("database/data/projects.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Project::create(array(
                'name' => $obj->name,
                'project_code' => $obj->project_code
            ));
        }
    }
}
