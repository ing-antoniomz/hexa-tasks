<?php

namespace App\Domain\Task\Events;

use App\Domain\Task\Entities\Task;
use DateTimeImmutable;

final class TaskCompleted
{
    private Task $task;
    private DateTimeImmutable $occurredOn;

    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function task(): Task
    {
        return $this->task;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
