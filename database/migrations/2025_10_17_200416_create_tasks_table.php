<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // id BIGINT AUTO_INCREMENT
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending | in_progress | completed
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null'); // si el usuario se borra, se libera la tarea
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
