<?php

namespace App\Domain\User\Entities;

use DateTimeImmutable;

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;
    private DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        string $name,
        string $email,
        string $password,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }
}
