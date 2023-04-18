<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetEarlyAdopterController extends BaseController
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
        $user = $this->userDataSource->findByEmail($userEmail);
        if (is_null($user)) {
            return response()->json(
                ['error' => 'usuario no encontrado'],
                Response::HTTP_NOT_FOUND
            );
        }
        if ($user->getId() < 1000) {
            return response()->json(
                ['El usuario es early adopter'],
                Response::HTTP_OK
            );
        }
        return response()->json(
            ['El usuario no es early adopter'],
            Response::HTTP_OK
        );
    }
}
