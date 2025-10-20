<?php

namespace App\Domain\Task\ValueObjects;

use InvalidArgumentException;

final class TaskStatus
{
    public const PENDING = 'pending';
    public const IN_PROGRESS = 'in_progress';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::allowedValues(), true)) {
            throw new InvalidArgumentException("Estado de tarea inválido: {$value}");
        }

        $this->value = $value;
    }

    public static function allowedValues(): array
    {
        return [
            self::PENDING,
            self::IN_PROGRESS,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isCompleted(): bool
    {
        return $this->value === self::COMPLETED;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(TaskStatus $other): bool
    {
        return $this->value === $other->value();
    }
}
