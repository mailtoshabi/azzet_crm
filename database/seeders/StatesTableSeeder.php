<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Andhra Pradesh', 'code' => 'AP'],
            ['name' => 'Arunachal Pradesh', 'code' => 'AR'],
            ['name' => 'Assam', 'code' => 'AS'],
            ['name' => 'Bihar', 'code' => 'BR'],
            ['name' => 'Chhattisgarh', 'code' => 'CT'],
            ['name' => 'Goa', 'code' => 'GA'],
            ['name' => 'Gujarat', 'code' => 'GJ'],
            ['name' => 'Haryana', 'code' => 'HR'],
            ['name' => 'Himachal Pradesh', 'code' => 'HP'],
            ['name' => 'Jharkhand', 'code' => 'JH'],
            ['name' => 'Karnataka', 'code' => 'KA'],
            ['name' => 'Kerala', 'code' => 'KL'],
            ['name' => 'Madhya Pradesh', 'code' => 'MP'],
            ['name' => 'Maharashtra', 'code' => 'MH'],
            ['name' => 'Manipur', 'code' => 'MN'],
            ['name' => 'Meghalaya', 'code' => 'ML'],
            ['name' => 'Mizoram', 'code' => 'MZ'],
            ['name' => 'Nagaland', 'code' => 'NL'],
            ['name' => 'Odisha', 'code' => 'OR'],
            ['name' => 'Punjab', 'code' => 'PB'],
            ['name' => 'Rajasthan', 'code' => 'RJ'],
            ['name' => 'Sikkim', 'code' => 'SK'],
            ['name' => 'Tamil Nadu', 'code' => 'TN'],
            ['name' => 'Telangana', 'code' => 'TG'],
            ['name' => 'Tripura', 'code' => 'TR'],
            ['name' => 'Uttar Pradesh', 'code' => 'UP'],
            ['name' => 'Uttarakhand', 'code' => 'UK'],
            ['name' => 'West Bengal', 'code' => 'WB'],
            ['name' => 'Andaman and Nicobar Islands', 'code' => 'AN'],
            ['name' => 'Chandigarh', 'code' => 'CH'],
            ['name' => 'Dadra and Nagar Haveli and Daman and Diu', 'code' => 'DN'],
            ['name' => 'Lakshadweep', 'code' => 'LD'],
            ['name' => 'Delhi', 'code' => 'DL'],
            ['name' => 'Puducherry', 'code' => 'PY'],
            ['name' => 'Ladakh', 'code' => 'LA'],
            ['name' => 'Jammu and Kashmir', 'code' => 'JK']
        ];

        DB::table('states')->insert($states);
    }
}
