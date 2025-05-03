<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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


        // \App\Models\Product::factory()->count(10)->create();

        // Tạo CSDL ảo User
        $this->call(UserSeeder::class); 
        // Tạo CSDL ảo product
        $this->call(ProductSeeder::class);
        // Tạo CSDL ảo Customer
        $this->call(CustomerSeeder::class);
        // Tạo CSDL ảo Supplier
        $this->call(SupplierSeeder::class);
    }
}
