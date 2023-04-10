<?php

namespace Tests\app\Infrastructure\Controller;

use Tests\TestCase;

class GetEarlyAdopterControllerTest extends TestCase
{
    /**
     * @test
     */
    public function userIsNotFound()
    {
        $response = $this->get("/api/earlyAdopter/email@email.com");

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }
}
