<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'id' => 1,
            'name' => 'Kanal D - XYZ Seti',
            'created_by' => 1
        ]);

        DB::table('companies')->insert([
            'id' => 2,
            'name' => 'TRT Belgesel - Dağ Gezileri Seti',
            'created_by' => 1,
            'updated_by' => 2,
            'updated_at' => new \DateTime(),
        ]);
    }
}
