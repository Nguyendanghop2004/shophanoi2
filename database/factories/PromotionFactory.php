<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(25),
            'description' =>$this->faker->text(225),
            'discount_percentage'=>rand(),
            'start_date'  => $this->faker->dateTimeBetween('-1 year', 'now'), 
            'end_date'  => $this->faker->dateTimeBetween('-1 year', 'now'), 
        ];
    }
}
