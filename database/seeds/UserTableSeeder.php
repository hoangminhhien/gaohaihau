<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();
        $json = File::get("database/data/users.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            User::create(array(
                'name' => $obj->name,
                'email' => $obj->email,
                'password' => Hash::make($obj->password),
                'role' => $obj->role
            ));
        }
    }
}
