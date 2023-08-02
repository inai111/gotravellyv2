<?php

namespace Database\Factories;

use App\Models\Continents;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Countries>
 */
class CountriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'short_code'=>$this->faker->unique()->country(),
            'name'=>$this->faker->unique()->country(),
            'continent_id'=>Continents::factory()
        ];
    }
}
