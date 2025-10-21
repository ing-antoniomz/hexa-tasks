<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Entities\Task as DomainTask;
use App\Domain\Task\ValueObjects\TaskStatus;
use App\Models\Task as EloquentTask;
use DateTimeImmutable;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data): DomainTask
    {
        $eloquentTask = EloquentTask::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? '',
            'status'      => $data['status'] ?? TaskStatus::PENDING,
            'user_id'     => $data['user_id'] ?? null,
        ]);

        return $this->mapToDomain($eloquentTask);
    }

    public function find(int $id): ?DomainTask
    {
        $eloquentTask = EloquentTask::find($id);
        return $eloquentTask ? $this->mapToDomain($eloquentTask) : null;
    }

    public function update(DomainTask $task, array $data): DomainTask
    {
        $eloquentTask = EloquentTask::find($task->getId());

        if (! $eloquentTask) {
            throw new \RuntimeException("Tarea no encontrada.");
        }

        $eloquentTask->fill([
            'title'       => $data['title'] ?? $eloquentTask->title,
            'description' => $data['description'] ?? $eloquentTask->description,
            'status'      => $data['status'] ?? $task->getStatus()->value(),
            'user_id'     => $data['user_id'] ?? $eloquentTask->user_id,
        ]);

        $eloquentTask->save();

        return $this->mapToDomain($eloquentTask);
    }

    public function all(): iterable
    {
        return EloquentTask::all()
            ->map(fn($eloquentTask) => $this->mapToDomain($eloquentTask));
    }

    private function mapToDomain(EloquentTask $eloquentTask): DomainTask
    {
        return new DomainTask(
            id: $eloquentTask->id,
            title: $eloquentTask->title,
            description: $eloquentTask->description,
            status: new TaskStatus($eloquentTask->status),
            userId: $eloquentTask->user_id,
            createdAt: new DateTimeImmutable($eloquentTask->created_at ?? 'now')
        );
    }
}
