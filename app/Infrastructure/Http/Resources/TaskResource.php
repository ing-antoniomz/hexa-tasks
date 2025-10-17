<?php

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'status' => (string) $this->getStatus(),
            'user_id' => $this->getUserId(),
        ];
    }
}
