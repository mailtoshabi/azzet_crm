<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
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
        // \App\Models\User::factory(10)->create();
        $this->call(StatesTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        Category::factory(100)->create();
        Customer::factory(300)->create();
    }
}
