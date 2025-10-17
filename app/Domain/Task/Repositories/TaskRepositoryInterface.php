<?php

namespace App\Domain\Task\Repositories;

use App\Domain\Task\Entities\Task;

interface TaskRepositoryInterface
{
    public function create(array $data): Task;
    public function find(int $id): ?Task;
    public function update(Task $task, array $data): bool;
    public function all(): iterable;
}
