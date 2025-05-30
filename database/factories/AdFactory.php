<?php

namespace Database\Factories;

use App\Models\Ads;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
  

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 10, 5000),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['pending', 'active', 'rejected']),
            
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
