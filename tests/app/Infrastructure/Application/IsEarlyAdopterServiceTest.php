<?php

namespace Tests\app\Infrastructure\Application;

use App\Application\IsEarlyAdopterService;
use App\Application\Exceptions\UserNotFoundException;
use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Controllers\UserResponse;
use Tests\TestCase;
use Mockery;

class IsEarlyAdopterServiceTest extends TestCase
{
    private UserDataSource $userDataSource;
    private IsEarlyAdopterService $isEarlyAdopterService;

    protected function setUp(): void
    {
        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->isEarlyAdopterService = new IsEarlyAdopterService($this->userDataSource);
    }
    /**
     * @test
     */
    public function userNotFoundByEmail()
    {
        $email = "email@email.com";
        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->andReturnNull();

        $this->expectException(UserNotFoundException::class);

        $this->isEarlyAdopterService->execute($email);
    }

    /**
     * @test
     */
    public function isEarlyAdopterUser()
    {
        $email = "email@email.com";
        $user = new User(2, $email);

        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->andReturn($user);

        $isEarlyAdopterUser = $this->isEarlyAdopterService->execute($email);
        $this->assertTrue($isEarlyAdopterUser);
    }

    /**
     * @test
     */
    public function isNotEarlyAdopterUser()
    {
        $email = "email@email.com";
        $user = new User(1023, $email);

        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->andReturn($user);

        $isEarlyAdopterUser = $this->isEarlyAdopterService->execute($email);
        $this->assertFalse($isEarlyAdopterUser);
    }
}
