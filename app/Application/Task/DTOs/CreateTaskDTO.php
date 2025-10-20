<?php

namespace App\Application\Task\DTOs;

class CreateTaskDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public int $userId
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            $data['user_id']
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->userId,
        ];
    }
}
