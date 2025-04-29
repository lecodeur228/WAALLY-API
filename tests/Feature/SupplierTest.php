<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    //  use RefreshDatabase; // Vide la base après chaque test

    /** @test */
    public function user_can_create_supplier()
    {
        $response = $this->postJson('/api/v1/suppliers', [
            'name' => 'Test Supplier',
            'phone' =>  '0612345678',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(201); // Code 201 = Created
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Test Supplier',
            'phone' => '0612345678',
        ]);
    }

    /** @test */
    public function user_can_get_suppliers()
    {
        $response = $this->getJson('/api/v1/suppliers',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_get_supplier()
    {
        $response = $this->getJson('/api/v1/suppliers/1',[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_update_supplier()
    {
        $response = $this->putJson('/api/v1/suppliers/update/1', [
            'name' => 'Test Supplier',
            'phone' =>  '0612345678',
        ],[
            'x-api-key' => 'nQZNySDKQoNb8bMi7fyIhuZNArMqt8whpK7EAqpMvrWvswJXWyaNGKwbLCZud2N9',
            'Authorization' => '1|s2jEnAPfomWQJ6otmFSrDFkPr9tJM3Y7pigeI1YLefc66cb6'
        ]);

        $response->assertStatus(200); // Code 200 = OK
    }

    /** @test */
    public function user_can_delete_supplier()
    {
        $response = $this->deleteJson('/api/v1/suppliers/delete/1');

        $response->assertStatus(200); // Code 200 = OK
    }
}
