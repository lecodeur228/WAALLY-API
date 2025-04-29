<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{

    /** @test */
    public function user_can_create_customer()
    {
        $response = $this->postJson('/api/v1/customers/create', [
            'name' => 'Test Customer',
            'phone' =>  '0612345678',

        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(201); // Code 201 = Created
    }

    /** @test */
    public function user_can_get_customers()
    {
        $response = $this->getJson('/api/v1/customers',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_customer()
    {
        $response = $this->getJson('/api/v1/customers/1',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_update_customer()
    {
        $response = $this->putJson('/api/v1/customers/update/1', [
            'name' => 'Test Customer',
            'phone' =>  '0612345678',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_delete_customer()
    {
        $response = $this->deleteJson('/api/v1/customers/delete/1');

        $response->assertStatus(200); // Code 200 = OK
    }
    
}
