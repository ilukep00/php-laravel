<?php

namespace App\Infrastructure\Controllers;

class UserListResponseMapper
{
    public function map(array $users): array
    {
        if (empty($users)) {
            return [];
        }
        $listUsers = [];
        foreach ($users as $user) {
            $listUsers[] = new UserResponse($user);//array("id" => $user->getId(),"email" => $user->getEmail());
        }
        return $listUsers;
    }
}
