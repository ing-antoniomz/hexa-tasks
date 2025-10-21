<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTaskRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        // Ajusta según tu sistema de permisos
        return true;
    }

    /**
     * Reglas de validación para asignar una tarea a un usuario
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id', // Debe ser un ID de usuario válido
        ];
    }

    /**
     * Mensajes personalizados (opcional)
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'El ID del usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
        ];
    }
}
