<?php

namespace App\Application\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class UserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("user not found");
    }
}
