<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(DepotSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ProductStatusSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(RentFormStatusSeeder::class);
    }
}
