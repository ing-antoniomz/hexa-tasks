<?php

namespace App\Domain\Task\Services;

use App\Domain\Task\Entities\Task;
use App\Domain\User\Entities\User;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Events\TaskCompleted;
use App\Domain\Task\ValueObjects\TaskStatus;
use Illuminate\Support\Facades\Event;

/**
 * Servicio de dominio para manejar la lógica de negocio de tareas.
 */
class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Crea una nueva tarea en memoria (no la persiste).
     */
    public function createTask(string $title, string $description, int $userId): Task
    {
        return new Task(
            id: 0, // aún no persistida
            title: $title,
            description: $description,
            status: new TaskStatus(TaskStatus::PENDING),
            userId: $userId
        );
    }

    /**
     * Asigna una tarea a un usuario (modifica la entidad).
     */
    public function assignToUser(Task $task, User $user): void
    {
        $task->assignTo($user->getId());
    }

    /**
     * Marca una tarea como completada.
     */
    public function completeTask(Task $task): void
    {
        if (! $task->canBeCompleted()) {
            throw new \DomainException("La tarea no puede completarse.");
        }

        $task->markAsCompleted();

        // Emitir evento de dominio
        Event::dispatch(new TaskCompleted($task));
    }
}
