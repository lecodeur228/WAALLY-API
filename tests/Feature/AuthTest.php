<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    //  use RefreshDatabase; // Vide la base après chaque test

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/v1/users/register', [
            'name' => 'Test User',
            'phone' =>  '0612345678',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201); // Code 201 = Created
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9'
        ]);
    }

    public function user_can_login()
    {

        $response = $this->postJson('/api/v1/users/login', [
            'email_or_phone' => 'test@example.com',
            'password' => 'password',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }
}
