<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Task\UseCases\CreateTaskUseCase;
use App\Application\Task\UseCases\AssignTaskUseCase;
use App\Application\Task\UseCases\CompleteTaskUseCase;
use App\Application\Task\UseCases\ListTasksUseCase;
use App\Application\Task\DTOs\CreateTaskDTO;
use App\Infrastructure\Http\Requests\CreateTaskRequest;
use App\Infrastructure\Http\Requests\AssignTaskRequest;
use App\Infrastructure\Http\Resources\TaskResource;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TaskController
{
    public function __construct(
        private CreateTaskUseCase $createTaskUseCase,
        private AssignTaskUseCase $assignTaskUseCase,
        private CompleteTaskUseCase $completeTaskUseCase,
        private ListTasksUseCase $listTasksUseCase,
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Listar todas las tareas
     */
    public function index(): JsonResponse
    {
        $tasks = $this->listTasksUseCase->execute();
        return response()->json(TaskResource::collection($tasks));
    }

    /**
     * Crear tarea
     */
    public function store(CreateTaskRequest $request): JsonResponse
    {
        $data = $request->validated();

        $dto = new CreateTaskDTO(
            $data['title'],
            $data['description'] ?? null,
            $data['user_id'] ?? null
        );

        $task = $this->createTaskUseCase->execute($dto);

        return response()->json(new TaskResource($task), 201);
    }

    /**
     * Mostrar una tarea
     */
    public function show(int $taskId): JsonResponse
    {
        $task = $this->listTasksUseCase->find($taskId); // el UseCase expone un find()
        return response()->json(new TaskResource($task));
    }

    /**
     * Asignar tarea a un usuario
     */
    public function assign(AssignTaskRequest $request, int $taskId): JsonResponse
    {
        $userId = $request->validated()['user_id'];
        $task = $this->assignTaskUseCase->execute($taskId, $userId);
        return response()->json(new TaskResource($task));
    }

    /**
     * Completar tarea
     */
    public function complete(int $taskId): JsonResponse
    {
        $task = $this->completeTaskUseCase->execute($taskId);
        return response()->json(new TaskResource($task));
    }
}
