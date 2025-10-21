<?php

namespace App\Domain\Task\Entities;

use App\Domain\Task\ValueObjects\TaskStatus;
use DateTimeImmutable;

class Task
{
    private ?int $id;
    private string $title;
    private string $description;
    private TaskStatus $status;
    private ?int $userId;
    private DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        string $title,
        ?string $description,
        TaskStatus $status,
        ?int $userId = null,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description ?? '';
        $this->status = $status;
        $this->userId = $userId;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    // --- Getters ---
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    // --- Behavior (Domain Logic) ---
    public function assignTo(int $userId): void
    {
        $this->userId = $userId;
    }

    public function canBeCompleted(): bool
    {
        return $this->status->equals(new TaskStatus(TaskStatus::PENDING))
            || $this->status->equals(new TaskStatus(TaskStatus::IN_PROGRESS));
    }

    public function markAsCompleted(): void
    {
        if (! $this->canBeCompleted()) {
            throw new \DomainException('La tarea no puede completarse desde su estado actual.');
        }

        $this->status = new TaskStatus(TaskStatus::COMPLETED);
    }
}
