<?php

namespace App\Infrastructure\Controllers;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\isEarlyAdopterService;
use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetEarlyAdopterController extends BaseController
{
    private isEarlyAdopterService $isEarlyAdopterService;

    /**
     * @param UserDataSource $userDataSource
     */
    public function __construct(isEarlyAdopterService $isEarlyAdopterService)
    {
        $this->isEarlyAdopterService = $isEarlyAdopterService;
    }

    public function __invoke(string $userEmail): JsonResponse
    {
        try {
            $isEarlyAdopter = $this->isEarlyAdopterService->execute($userEmail);
            if ($isEarlyAdopter) {
                return response()->json(
                    ['El usuario es early adopter'],
                    Response::HTTP_OK
                );
            }
            return response()->json(
                ['El usuario no es early adopter'],
                Response::HTTP_OK
            );
        } catch (UserNotFoundException) {
            return response()->json(
                ['error' => 'usuario no encontrado'],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
