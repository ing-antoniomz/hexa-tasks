<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos 10 usuarios
        User::factory()->count(10)->create();
    }
}
