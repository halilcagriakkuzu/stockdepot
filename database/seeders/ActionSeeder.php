<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->insert([
            'id' => 1,
            'type' => 'RENT_TO_COMPANY',
            'description' => 'Depodan aktif bir ürünü kiralık olarak bir firmaya verme aksiyonu. Bu durumdaki ürün forma eklenemez',
        ]);

        DB::table('actions')->insert([
            'id' => 2,
            'type' => 'RENT_BACK_FROM_COMPANY_TO_DEPOT',
            'description' => 'Firmaya gönderilmiş bir ürünün depoya sağlam bir şekilde geri gelme aksiyonu. Bu durumdaki ürün forma eklenebilir hale gelir.',
        ]);

        DB::table('actions')->insert([
            'id' => 3,
            'type' => 'RENT_BACK_FROM_COMPANY_TO_MAINTENANCE',
            'description' => 'Firmaya gönderilmiş bir ürünün firmadan arızalı olarak gelmesi ve depo yerine ölçü bakıma gönderilme aksiyonu. Bu durumdaki ürün forma eklenemez',
        ]);

        DB::table('actions')->insert([
            'id' => 4,
            'type' => 'SEND_TO_MAINTENANCE_FROM_DEPOT',
            'description' => 'Depodaki bir ürünün ölçü bakıma gönderilme aksiyonu. Bu durumdaki ürün forma eklenemez',
        ]);

        DB::table('actions')->insert([
            'id' =>5,
            'type' => 'SEND_TO_DEPOT_FROM_MAINTENANCE',
            'description' => 'Ölçü/Bakımdaki bir ürünün tekrar depoya gönderilme aksiyonu. Bu durumdaki ürün forma eklenebilir',
        ]);

        DB::table('actions')->insert([
            'id' => 6,
            'type' => 'MARK_AS_DISABLED',
            'description' => 'Depodaki bir ürünün kullanılamaz olduğunu gösteren aksiyon, bu aksiyon sonrası ürün aktiften pasife geçer',
        ]);
    }
}
