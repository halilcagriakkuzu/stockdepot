<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'id' => 1,
            'name' => 'Body',
            'description' => 'Kamera body ürünü',
            'depot_id' => 1
        ]);

        DB::table('categories')->insert([
            'id' => 2,
            'name' => 'Lens',
            'description' => 'Kamera lensleri(objektifleri)',
            'depot_id' => 1
        ]);

        DB::table('categories')->insert([
            'id' => 3,
            'name' => 'Tripod',
            'description' => 'Kamera için tripodlar',
            'depot_id' => 1
        ]);

        DB::table('categories')->insert([
            'id' => 4,
            'name' => 'Ses Mikseri',
            'description' => 'Seslerin giriş çıkışını yapan aletler',
            'depot_id' => 2
        ]);

        DB::table('categories')->insert([
            'id' => 5,
            'name' => 'Mikrofon',
            'description' => 'Kayıt için kullanılan mikrofonlar',
            'depot_id' => 2
        ]);
    }
}
