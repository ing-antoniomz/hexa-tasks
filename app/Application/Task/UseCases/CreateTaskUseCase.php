<?php

namespace App\Application\Task\UseCases;

use App\Application\Task\DTOs\CreateTaskDTO;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Services\TaskService;
use App\Domain\Task\Entities\Task;

class CreateTaskUseCase
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskService $taskService
    ) {}

    public function execute(CreateTaskDTO $dto): Task
    {
        // 1. Crear la entidad desde el DTO
        $task = $this->taskService->createTask($dto->title, $dto->description, $dto->userId);

        // 2. Guardar la tarea en el repositorio
        return $this->taskRepository->create([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus()->value(),
            'user_id' => $task->getUserId(),
        ]);
    }
}
