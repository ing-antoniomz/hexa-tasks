<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Task\UseCases\CreateTaskUseCase;
use App\Application\Task\DTOs\CreateTaskDTO;
use App\Infrastructure\Http\Requests\CreateTaskRequest;
use App\Infrastructure\Http\Resources\TaskResource;
use Illuminate\Http\JsonResponse;

class TaskController
{
    private CreateTaskUseCase $createTaskUseCase;

    public function __construct(CreateTaskUseCase $createTaskUseCase)
    {
        $this->createTaskUseCase = $createTaskUseCase;
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $dto = new CreateTaskDTO(
            $request->validated('title'),
            $request->validated('description'),
            $request->validated('user_id')
        );

        $task = $this->createTaskUseCase->execute($dto);

        return response()->json(new TaskResource($task), 201);
    }
}
