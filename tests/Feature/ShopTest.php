<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTest extends TestCase
{
    //  use RefreshDatabase; // Vide la base après chaque test

    /** @test */
    public function user_can_create_shop()
    {
        $response = $this->postJson('/api/v1/shops/create', [
            'name' => 'Test Shop',
            'location' => '{"latitude": 0, "longitude": 0}',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);
        // dd($response);
        $response->assertStatus(201); // Code 201 = Created
    }

    /** @test */
    public function user_can_get_shops()
    {
        $response = $this->getJson('/api/v1/shops',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_shop()
    {
        $response = $this->getJson('/api/v1/shops/1',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_shops_by_user()
    {
        $response = $this->getJson('/api/v1/shops/shopsByUser',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_update_shop()
    {
        $response = $this->putJson('/api/v1/shops/update/1', [
            'name' => 'Test Shop',
            'location' => '{"latitude": 0, "longitude": 0}',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_delete_shop()
    {
        $response = $this->deleteJson('/api/v1/shops/delete/1',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }
}
