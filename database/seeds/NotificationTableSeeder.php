<?php

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('notifications')->truncate();
        $json = File::get("database/data/notifications.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Notification::create(array(
                'type' => $obj->type,
                'from_id' => $obj->from_id,
                'to_id' => $obj->to_id,
                'title' => $obj->title,
                'object_type' => $obj->object_type,
                'content' => $obj->content,
                'data' => $obj->data,
            ));
        }
    }
}
