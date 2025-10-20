<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos 50 tareas aleatorias
        Task::factory()->count(50)->create();
    }
}
