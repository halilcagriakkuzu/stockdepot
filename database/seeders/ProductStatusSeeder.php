<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_statuses')->insert([
            'name' => 'IN_DEPOT',
            'description' => 'Malzeme şuan depoda, kullanılabilir durumda.',
            'color' => 'success',
        ]);

        DB::table('product_statuses')->insert([
            'name' => 'RENTED',
            'description' => 'Malzeme şuan bir firmada kiralık olarak durmakta.',
            'color' => 'danger',
        ]);

        DB::table('product_statuses')->insert([
            'name' => 'IN_MAINTENANCE',
            'description' => 'Malzeme şuan ölçü/bakımda durmakta',
            'color' => 'danger',
        ]);

        DB::table('product_statuses')->insert([
            'name' => 'DISABLED',
            'description' => 'malzeme kullanım dışı',
            'color' => 'danger',
        ]);

        DB::table('product_statuses')->insert([
            'name' => 'OUT_OF_STOCK',
            'description' => 'malzeme stoklarda kalmadı',
            'color' => 'danger',
        ]);
    }
}
