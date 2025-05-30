<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'ad_id' => Ad::inRandomOrder()->first()->id,
            'rating' => $this->faker->numberBetween(1, 5), 
            'comment' => $this->faker->optional()->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
