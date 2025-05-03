<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = [
            ['username' => 'nam', 'full_name' => 'HoaiNam', 'role'=>'manager'],
            ['username' => 'trang', 'full_name' => 'Như Tragn','role'=>'sales_agent'],
            ['username' => 'luyen', 'full_name' => 'Quang luyem','role'=>'warehouse_worker'],
            ['username' => 'huan', 'full_name' => 'Minh Huan','role'=>'sales_agent'],
        ];
    
        foreach ($users as $u) {
            \App\Models\User::create([
                'username' => $u['username'],
                'password' => Hash::make('123456'),
                'full_name' => $u['full_name'],
                'role'=> $u['role'],
            ]);
        }
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
