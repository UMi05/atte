<?php

namespace Database\Factories;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber(),
            'work_id' => \App\Models\Work::factory(),
            'start_rest' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'end_rest' => $this->faker->time($format = 'H:i:s', $max = 'now'),
        ];
    }
}
