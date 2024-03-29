<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'mouhcine4@gmail.com',
            'password' => 'password',
            'role' => 6,
        ];

        $response = $this->json('POST', '/api/auth/signup', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User registered successfully'
            ]);
    }
}
