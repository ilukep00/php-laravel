<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class GetUsersController extends BaseController
{
    private UserDataSource $userDataSource;

    /**
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    public function __invoke(): JsonResponse
    {
        $users = $this->userDataSource->getAll();
        if (empty($users)) {
            return response()->json([]);
        }
        $jsonUsers = array();
        foreach ($users as $user) {
            $jsonUsers[] = array("id" => $user->getId(),"email" => $user->getEmail());
        }
        return response()->json($jsonUsers);
    }
}
