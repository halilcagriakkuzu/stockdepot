<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentFormStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rent_form_statuses')->insert([
            'name' => 'DRAFT',
            'description' => 'Form şuan taslak durumda, malzeme eklenip çıkartılabilir. Malzemelerin tarihçesini ve durumunu etkilemez.',
            'color' => 'info',
        ]);

        DB::table('rent_form_statuses')->insert([
            'name' => 'ACTIVE',
            'description' => 'Form şuan aktif durumda, içerisine malzeme eklemek/çıkartmak, malzemelnin durumunu değiştirir.',
            'color' => 'success',
        ]);

        DB::table('rent_form_statuses')->insert([
            'name' => 'DONE',
            'description' => 'Kiralama tamamlanmış, artık ürün ekleyip çıkartılamaz.',
            'color' => 'danger',
        ]);
    }
}
