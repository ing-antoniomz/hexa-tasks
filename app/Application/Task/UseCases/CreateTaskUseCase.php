<?php

namespace App\Application\Task\UseCases;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Entities\Task;
use App\Domain\Task\ValueObjects\TaskStatus;

class CreateTaskUseCase
{
    private TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): Task
    {
        // Aquí puedes transformar los datos si quieres
        $data['status'] = $data['status'] ?? TaskStatus::PENDING;

        return $this->repository->create($data);
    }
}
