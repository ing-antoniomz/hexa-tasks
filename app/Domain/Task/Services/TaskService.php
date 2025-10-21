<?php

namespace App\Domain\Task\Services;

use App\Domain\Task\Entities\Task;
use App\Domain\User\Entities\User;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Events\TaskCompleted;
use App\Domain\Task\ValueObjects\TaskStatus;
use Illuminate\Support\Facades\Event;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {}

    public function createTask(string $title, string $description, int $userId): Task
    {
        return new Task(
            id: 0,
            title: $title,
            description: $description,
            status: new TaskStatus(TaskStatus::PENDING),
            userId: $userId
        );
    }

    public function assignToUser(Task $task, User $user): Task
    {
        $task->assignTo($user->getId());

        return $this->taskRepository->update($task, [
            'user_id' => $user->getId()
        ]);
    }

    public function completeTask(Task $task): Task
    {
        if ($task->isCompleted()) {
            return $task;
        }

        if (! $task->canBeCompleted()) {
            throw new \DomainException("La tarea no puede completarse.");
        }


        $task->markAsCompleted();

        $updatedTask = $this->taskRepository->update($task, [
            'status' => $task->getStatus()->value()
        ]);

        Event::dispatch(new TaskCompleted($updatedTask));

        return $updatedTask;
    }
}
