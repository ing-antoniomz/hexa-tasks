<?php

namespace App\Application\Task\UseCases;

use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Entities\Task;

class ListTasksUseCase
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    /**
     * Devuelve todas las tareas
     *
     * @return Task[]
     */
    public function execute(): iterable
    {
        return $this->taskRepository->all();
    }

    /**
     * Encuentra una tarea por ID
     *
     * @param int $id
     * @return Task|null
     */
    public function find(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }
}
