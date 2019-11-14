<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductTableSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(BuildingTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(NotificationTableSeeder::class);
    }
}
