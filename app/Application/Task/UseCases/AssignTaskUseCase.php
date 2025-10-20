<?php

namespace App\Application\Task\UseCases;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Domain\Task\Services\TaskService;

class AssignTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskService $taskService
    ) {}

    public function execute(int $taskId, User $user): bool
    {
        $task = $this->taskRepository->find($taskId);
        if (!$task) {
            throw new \Exception("Task not found");
        }

        $this->taskService->assignToUser($task, $user);
        return $this->taskRepository->update($task, [
            'user_id' => $user->getId()
        ]);
    }
}
