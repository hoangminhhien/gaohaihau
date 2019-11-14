<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->truncate();
        $json = File::get("database/data/products.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            if(empty($obj->gift_code)) {
                $obj->gift_code = null;
            }
            Product::create(array(
                'name' => $obj->name,
                'made_from' => $obj->made_from,
                'unit' => $obj->unit,
                'capacity' => $obj->capacity,
                'price' => $obj->price,
                'image_url' => $obj->image_url,
                'short_desc' => $obj->short_desc,
                'desc' => $obj->desc,
                'quantity' => $obj->quantity,
                'is_public' => $obj->is_public,
                'gift_code' => $obj->gift_code
            ));
        } 
    }
}
