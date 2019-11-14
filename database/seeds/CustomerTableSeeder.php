<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('customers')->truncate();
        $json = File::get("database/data/customers.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Customer::create(array(
                'name' => $obj->name,
                'project_code' => $obj->project_code,
                'building_code' => $obj->building_code,
                'room_no' => $obj->room_no,
                'phone' => $obj->phone,
                'family_number_of_adults' => $obj->family_number_of_adults,
                'family_number_of_children' => $obj->family_number_of_children
            ));
        }

    }
}
