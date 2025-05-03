<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['username' => 'nam', 'full_name' => 'HoaiNam', 'role' => 'manager'],
            ['username' => 'trang', 'full_name' => 'Như Tragn', 'role' => 'sales_agent'],
            ['username' => 'luyen', 'full_name' => 'Quang luyem', 'role' => 'warehouse_worker'],
            ['username' => 'huan', 'full_name' => 'Minh Huan', 'role' => 'sales_agent'],
        ];

        foreach ($users as $u) {
            User::create([
                'username' => $u['username'],
                'password' => Hash::make('123456'),
                'full_name' => $u['full_name'],
                'role' => $u['role'],
            ]);
        }
    }
}
