<?php

namespace App\Domain\Task\Services;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Entities\Task;
use App\Domain\Task\Events\TaskCompleted;
use Illuminate\Support\Facades\Event;

/**
 * Servicio de dominio para manejar la lógica de negocio de tareas.
 */
class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $tasks
    ) {}

    /**
     * Asignar una tarea a un usuario
     */
    public function assignTask(int $taskId, int $userId): Task
    {
        $task = $this->tasks->find($taskId);
        if (! $task) {
            throw new \RuntimeException("Tarea no encontrada.");
        }

        $task->assignTo($userId);
        $this->tasks->update($task, ['user_id' => $userId]);

        return $task;
    }

    /**
     * Completar una tarea
     */
    public function completeTask(int $taskId): Task
    {
        $task = $this->tasks->find($taskId);
        if (! $task) {
            throw new \RuntimeException("Tarea no encontrada.");
        }

        if (! $task->canBeCompleted()) {
            throw new \DomainException("La tarea no puede completarse.");
        }

        $task->markAsCompleted();

        // Persistimos el cambio usando el repositorio
        $this->tasks->update($task, ['status' => $task->status]);

        // Evento de dominio
        Event::dispatch(new TaskCompleted($task));

        return $task;
    }
}
