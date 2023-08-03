<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;
    public function definition(): array
    {
        return [
            'task'=>$this->faker->sentence(),
            'description'=>$this->faker->paragraph(),
            'progress'=>$this->faker->sentence(),
            'position'=>$this->faker->sentence(),
            'start_date'=>$this->faker->date(),
            'end_date'=>$this->faker->date(),

        ];
    }
}
