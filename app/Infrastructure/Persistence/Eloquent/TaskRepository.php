<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Entities\Task as DomainTask;
use App\Domain\Task\ValueObjects\TaskStatus;
use App\Models\Domain\Task\Entities\Task as EloquentTask;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * Crea una nueva tarea
     */
    public function create(array $data): DomainTask
    {
        $eloquentTask = EloquentTask::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? TaskStatus::PENDING,
            'user_id' => $data['user_id'] ?? null,
        ]);

        return $this->mapToDomain($eloquentTask);
    }

    /**
     * Busca una tarea por ID
     */
    public function find(int $id): ?DomainTask
    {
        $eloquentTask = EloquentTask::find($id);

        return $eloquentTask ? $this->mapToDomain($eloquentTask) : null;
    }

    /**
     * Actualiza una tarea
     */
    public function update(DomainTask $task, array $data): bool
    {
        $eloquentTask = EloquentTask::find($task->getId());

        if (!$eloquentTask) {
            return false;
        }

        $eloquentTask->fill([
            'title' => $data['title'] ?? $eloquentTask->title,
            'description' => $data['description'] ?? $eloquentTask->description,
            'status' => $data['status'] ?? $eloquentTask->status,
            'user_id' => $data['user_id'] ?? $eloquentTask->user_id,
        ]);

        return $eloquentTask->save();
    }

    /**
     * Devuelve todas las tareas
     */
    public function all(): iterable
    {
        return EloquentTask::all()->map(fn($eloquentTask) => $this->mapToDomain($eloquentTask));
    }

    /**
     * Mapea un modelo Eloquent a la entidad de dominio
     */
    private function mapToDomain(EloquentTask $eloquentTask): DomainTask
    {
        return new DomainTask(
            $eloquentTask->id,
            $eloquentTask->title,
            $eloquentTask->description,
            new TaskStatus($eloquentTask->status),
            $eloquentTask->user_id
        );
    }
}
