<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(2, true), // Tên ảo gồm 2 từ
            'price' => mt_rand(10000, 1000000),
            'quatility' => mt_rand(1, 100),
            'img' => '', // để trống
            'descriptions' => '', // để trống
        ];
    }
}
