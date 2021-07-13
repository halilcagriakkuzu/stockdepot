<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('depots')->insert([
            'id' => 1,
            'name' => 'Kamera Depo',
            'description' => 'Kamera ve benzer ekipmanların bulunduğu depo',
        ]);

        DB::table('depots')->insert([
            'id' => 2,
            'name' => 'Ses Depo',
            'description' => 'Kamera ve benzer ekipmanların bulunduğu depo',
        ]);
    }
}
