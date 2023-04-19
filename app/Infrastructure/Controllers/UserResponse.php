<?php

namespace App\Infrastructure\Controllers;

use App\Domain\User;
//DTO --> modelar respuesta de la api
use JsonSerializable;

class UserResponse implements JsonSerializable
{
    private int $id;
    private string $email;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "email" => $this->email
        ];
    }
}
