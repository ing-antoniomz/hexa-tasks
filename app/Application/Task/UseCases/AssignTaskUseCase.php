<?php

namespace App\Application\Task\UseCases;

use App\Domain\Task\Entities\Task;
use App\Domain\User\Entities\User;
use App\Domain\Task\Services\TaskService;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;

class AssignTaskUseCase
{
    public function __construct(
        private TaskService $taskService,
        private TaskRepositoryInterface $taskRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(int $taskId, int $userId): Task
    {
        $task = $this->taskRepository->find($taskId);
        if (! $task) {
            throw new \RuntimeException("Tarea no encontrada");
        }

        $user = $this->userRepository->find($userId);
        if (! $user) {
            throw new \RuntimeException("Usuario no encontrado");
        }

        return $this->taskService->assignToUser($task, $user);
    }
}
