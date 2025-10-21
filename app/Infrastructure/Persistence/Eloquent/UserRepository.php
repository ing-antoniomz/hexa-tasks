<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Entities\User as DomainUser;
use App\Models\User as EloquentUser;
use DateTimeImmutable;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Busca un usuario por ID y lo convierte en entidad de dominio.
     */
    public function find(int $id): ?DomainUser
    {
        $eloquentUser = EloquentUser::find($id);

        if (! $eloquentUser) {
            return null;
        }

        return $this->mapToDomain($eloquentUser);
    }

    /**
     * Crea un usuario en la base de datos.
     */
    public function create(array $data): DomainUser
    {
        $eloquentUser = EloquentUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // recuerda encriptar si es necesario
        ]);

        return $this->mapToDomain($eloquentUser);
    }

    /**
     * Devuelve todos los usuarios como entidades de dominio.
     */
    public function all(): iterable
    {
        return EloquentUser::all()->map(fn($eloquentUser) => $this->mapToDomain($eloquentUser));
    }

    /**
     * Convierte un modelo Eloquent en una entidad de dominio.
     */
    private function mapToDomain(EloquentUser $eloquentUser): DomainUser
    {
        return new DomainUser(
            id: $eloquentUser->id,
            name: $eloquentUser->name,
            email: $eloquentUser->email,
            password: $eloquentUser->password,
            createdAt: new DateTimeImmutable($eloquentUser->created_at)
        );
    }
}
