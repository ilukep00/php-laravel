<?php

namespace App\Application;

use App\Application\UserDataSource\UserDataSource;
use App\Application\Exceptions\UserNotFoundException;

class IsEarlyAdopterService
{
    private UserDataSource $userDataSource;

    /**
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }
    public function execute(string $email): bool
    {
        $user = $this->userDataSource->findByEmail($email);

        if (is_null($user)) {
            throw new UserNotFoundException();
        }

        return $user->getId() < 100;
    }
}
