<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Mockery;

class GetUsersControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userDataSource;
        });
    }


    /**
     * @test
     */
    public function returnEmptyListIfNotUsers()
    {
        $this->userDataSource
            ->expects("getAll")
            ->andReturn([]);

        $response = $this->get("/api/users");

        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * @test
     */
    public function returnAllUsers()
    {
        $this->userDataSource
            ->expects("getAll")
            ->andReturn([new User(1, "email@email.com"), new User(2, "another_email@email.com")]);

        $response = $this->get("/api/users");

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has(2)
                 ->first(fn (AssertableJson $json) =>
                    $json->where('id', 1)
                         ->where('email', 'email@email.com'))
                 ->has('1', fn (AssertableJson $json) =>
                 $json->where('id', 2)
                     ->where('email', 'another_email@email.com')));
    }
}
