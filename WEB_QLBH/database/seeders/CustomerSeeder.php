<?php

namespace Database\Seeders;

use App\Models\customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            ['name' => 'Công Minh', 'phone' => '100000'],
            ['name' => 'Đắc Quân', 'phone' => '50000'],
            ['name' => 'Nguyễn Tuấn', 'phone' => '10000'],
            ['name' => 'Thu Hà', 'phone' => '20000'],
        ];

        foreach ($customers as $customer) {
            customer::create([
                'name' => $customer['name'],
                'phone' => $customer['phone'],
            ]);
        }
    }
}
