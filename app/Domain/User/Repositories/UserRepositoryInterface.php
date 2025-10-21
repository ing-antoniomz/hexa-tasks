<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UserRepositoryInterface
{
    /**
     * Busca un usuario por su ID.
     */
    public function find(int $id): ?User;

    /**
     * Crea un usuario en la base de datos.
     */
    public function create(array $data): User;

    /**
     * Devuelve todos los usuarios.
     */
    public function all(): iterable;
}
