<?php

namespace App\Domain\Task\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Entidad de dominio Task (tarea)
 *
 * Representa una tarea con atributos básicos y reglas simples.
 * Pertenece a un usuario (asignado) y puede tener estados.
 */
class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];

    // Estados válidos del dominio
    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';

    /**
     * Relación con usuario (si existe)
     */
    public function user()
    {
        return $this->belongsTo(\App\Domain\Entities\User::class);
    }

    /**
     * Determina si la tarea está completada
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Determina si la tarea puede ser marcada como completada
     */
    public function canBeCompleted(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_IN_PROGRESS]);
    }

    /**
     * Cambia el estado de la tarea a completado
     */
    public function markAsCompleted(): void
    {
        if (! $this->canBeCompleted()) {
            throw new \DomainException('La tarea no puede completarse desde su estado actual.');
        }

        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * Asigna un usuario a la tarea
     */
    public function assignTo(int $userId): void
    {
        $this->user_id = $userId;
    }
}
