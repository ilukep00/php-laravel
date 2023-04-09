<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class GetUsersController extends BaseController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([]);
    }
}
