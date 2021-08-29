<?php

namespace Database\Factories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber(),
            'user_id' => \App\Models\User::factory(),
            'start_work' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'end_work' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'attendance_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
