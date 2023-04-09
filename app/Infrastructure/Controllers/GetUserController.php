<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use App\Infrastructure\Persistence\FileUserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetUserController extends BaseController
{
    private UserDataSource $userDataSource;

    /**
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }


    public function __invoke(string $userEmail): JsonResponse
    {
        $user = $this -> userDataSource->findByEmail($userEmail);
        if (is_null($user)) {
            return response()->json([
                'error' => 'usuario no encontrado',
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'id' => str($user->getId()),
            'email' => $user->getEmail()
        ], Response::HTTP_OK);
    }
}
