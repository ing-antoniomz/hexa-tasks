<?php

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('api')->group(function () {
    // CRUD básico (index, store, show, update, destroy)
    Route::apiResource('tasks', TaskController::class)
        ->only(['index', 'store', 'show'/* , 'update', 'destroy' */]);

    // Acciones de dominio
    Route::post('tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
    Route::post('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    // Si usas autenticación (Sanctum) descomenta y envuelve:
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::apiResource('tasks', TaskController::class);
    //     Route::post('tasks/{task}/assign', [TaskController::class, 'assign']);
    //     Route::post('tasks/{task}/complete', [TaskController::class, 'complete']);
    // });
});
