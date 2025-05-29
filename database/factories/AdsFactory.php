<?php

namespace Database\Factories;

use App\Models\Ads;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ads>
 */
class AdsFactory extends Factory
{
  

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 10, 5000),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['pending', 'active', 'rejected']),
            
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
