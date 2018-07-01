<?php

namespace Tests\Feature;

use Tests\TestCase;

class EchoTest extends TestCase
{
    /**
     * @return void
     */
    public function testEcho()
    {
        $params = ['message' => 'Hello World'];
        $response = $this->json('GET', '/echo', $params);
        $response->assertOk()
            ->assertJson(['message' => 'Hello World']);

        $response = $this->json('GET', '/echo');
        $response->assertJsonValidationErrors(['message']);
    }
}
