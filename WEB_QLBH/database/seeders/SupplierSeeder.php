<?php

namespace Database\Seeders;

use App\Models\supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            ['name' => 'NCC Rạng Đông', 'phone' => '0123456789'],
            ['name' => 'NCC SIGMA', 'phone' => '0567755'],
            ['name' => 'NCC PANASONIC', 'phone' => '07897456456'],
            ['name' => 'NCC CREEN', 'phone' => '568787899'],
        ];

        foreach ($suppliers as $supplier) {
            supplier::create([
                'name' => $supplier['name'],
                'phone' => $supplier['phone'],
            ]);
        }
    }
}
