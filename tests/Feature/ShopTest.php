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
        ]);
        // dd($response);
        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_shops()
    {
        $response = $this->getJson('/api/v1/shops');

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_shop()
    {
        $response = $this->getJson('/api/v1/shops/1');

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_shops_by_user()
    {
        $response = $this->getJson('/api/v1/shops/shopsByUser');

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_update_shop()
    {
        $response = $this->putJson('/api/v1/shops/update/1', [
            'name' => 'Test Shop',
            'location' => '{"latitude": 0, "longitude": 0}',
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_delete_shop()
    {
        $response = $this->deleteJson('/api/v1/shops/delete/1');

        $response->assertStatus(200); // Code 200 = OK
    }
}
