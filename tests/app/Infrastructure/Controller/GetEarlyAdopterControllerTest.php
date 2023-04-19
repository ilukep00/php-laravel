<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\isEarlyAdopterService;
use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Tests\TestCase;
use Mockery;

class GetEarlyAdopterControllerTest extends TestCase
{
    private UserDataSource $userDataSource;
    private isEarlyAdopterService $isEarlyAdopter;
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->isEarlyAdopter = new isEarlyAdopterService($this->userDataSource);
        $this->app->bind(isEarlyAdopterService::class, function () {
            return  $this->isEarlyAdopter;
        });
    }


    /**
     * @test
     */
    public function userIsNotFound()
    {
        $this->userDataSource
            ->expects("findByEmail")
            ->with('email@email.com')
            ->andReturnNull();

        $response = $this->get("/api/user/early-adopter/email@email.com");

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }

    /**
     * @test
     */
    public function userIsEarlyAdopter()
    {
        $this->userDataSource
            ->expects("findByEmail")
            ->with('email@email.com')
            ->andReturn(new User(2, 'email@email.com'));

        $response = $this->get("/api/user/early-adopter/email@email.com");

        $response->assertOk();
        $response->assertExactJson(['El usuario es early adopter']);
    }

    /**
     * @test
     */
    public function userIsNotEarlyAdopter()
    {
        $this->userDataSource
            ->expects("findByEmail")
            ->with('email@email.com')
            ->andReturn(new User(1001, 'email@email.com'));

        $response = $this->get("/api/user/early-adopter/email@email.com");

        $response->assertOk();
        $response->assertExactJson(['El usuario no es early adopter']);
    }
}
