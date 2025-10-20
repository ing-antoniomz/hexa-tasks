<?php

namespace App\Application\Task\UseCases;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Services\TaskService;

class CompleteTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskService $taskService
    ) {}

    public function execute(int $taskId): bool
    {
        $task = $this->taskRepository->find($taskId);
        if (!$task) {
            throw new \Exception("Task not found");
        }

        $this->taskService->completeTask($task);
        return $this->taskRepository->update($task, [
            'status' => $task->getStatus()->value()
        ]);
    }
}
