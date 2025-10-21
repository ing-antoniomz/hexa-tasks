<?php

namespace App\Application\Task\UseCases;

use App\Domain\Task\Entities\Task;
use App\Domain\Task\Services\TaskService;
use App\Domain\Task\Repositories\TaskRepositoryInterface;

class CompleteTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskService $taskService
    ) {}

    public function execute(int $taskId): Task
    {
        $task = $this->taskRepository->find($taskId);
        if (!$task) {
            throw new \Exception("Task not found");
        }

        return $this->taskService->completeTask($task);

    }
}
