<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Tests\TestCase;

class GetUsersControllerTest extends TestCase
{
    private UserDataSource $userDataSource;
    /**
     * @test
     */
    public function returnEmptyListIfNotUsers(){

        $response = $this->get("/api/users");

        $response->assertOk();
        $response->assertExactJson([]);
    }
}
