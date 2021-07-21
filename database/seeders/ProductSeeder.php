<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 1111; $i++) {
            DB::table('products')->insert([
                'serial_number' => $faker->randomLetter().$faker->randomLetter().$faker->buildingNumber(),
                'make' => $faker->company(),
                'model' => $faker->text(10),
                'shelf_no' => $faker->randomLetter() .$faker->buildingNumber(),
                'row_no' => $faker->buildingNumber(),
                'count' => null,
                'unavailable_count' => null,
                'description' => $faker->realText(122),
                'buy_price' => $faker->randomNumber(4),
                'buy_date' => new \DateTime($faker->date('Y-m-d')),
                'category_id' => $faker->randomElement([1,2,3,4,5]),
                'product_status_id' => 1,
            ]);
        }
    }
}
