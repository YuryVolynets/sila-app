<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(asText: true);
        return [
            'name' => $name,
            'description' => fake()->sentence(),
            'slug' => Str::slug($name),
            'price_raw' => rand(100, 100000),
            'length_raw' => rand(10, 1000),
            'width_raw' => rand(10, 1000),
            'height_raw' => rand(10, 1000),
            'weight_raw' => rand(100, 100000),
            'folder_id' => rand(3, 14),
        ];
    }
}
