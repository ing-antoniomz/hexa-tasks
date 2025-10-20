<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $statuses = ['pending', 'in_progress', 'completed'];

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'user_id' => User::factory(), // genera un usuario asociado automáticamente
        ];
    }

    /**
     * Estado personalizado: tarea pendiente
     */
    public function pending(): static
    {
        return $this->state(fn() => ['status' => 'pending']);
    }

    /**
     * Estado personalizado: tarea completada
     */
    public function completed(): static
    {
        return $this->state(fn() => ['status' => 'completed']);
    }
}
