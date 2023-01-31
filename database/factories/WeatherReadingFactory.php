<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WeatherReading;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeatherReading>
 */
class WeatherReadingFactory extends Factory
{
    protected $model = WeatherReading::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'temp_c' => $this->faker->numberBetween(50,85),
            'temp_f' => $this->faker->numberBetween(0,25),
            'city' => $this->faker->city(),
            'region' => $this->faker->state()
        ];
    }
}
