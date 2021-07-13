<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'id' => 1,
            'serial_number' => 'SN123523A43',
            'make' => 'Canon',
            'model' => '5D Mark 4',
            'shelf_no' => 'A1',
            'row_no' => '5',
            'count' => null,
            'unavailable_count' => null,
            'description' => 'Kamera canon mark',
            'buy_price' => 2599,
            'buy_date' => new \DateTime(),
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'id' => 2,
            'serial_number' => 'Y780000911',
            'make' => 'Canon',
            'model' => '70-200 L IS 2',
            'shelf_no' => 'F5',
            'row_no' => '17',
            'count' => null,
            'unavailable_count' => null,
            'description' => 'Kamera lensi canon body için',
            'buy_price' => 1899,
            'buy_date' => new \DateTime(),
            'category_id' => 2
        ]);
    }
}
