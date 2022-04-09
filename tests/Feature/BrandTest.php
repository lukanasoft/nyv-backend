<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_all_brands()
    {
        $response = $this->get('/api/brands');

        $response->assertStatus(200);
    }

    public function test_get_a_brand()
    {
        $response = $this->get('/api/brands/1');

        $response->assertStatus(200);
    }

    public function test_store_a_brand()
    {
        $response = $this->post('/api/brands', [
            'name' => 'Brand 1',
            'description' => 'Brand 1 description',
            'image' => 'brand1.jpg',
        ]);

        $response->assertStatus(201);
    }

    public function test_update_a_brand()
    {
        $response = $this->put('/api/brands/1', [
            'name' => 'Brand 1',
            'description' => 'Brand 1 description',
            'image' => 'brand1.jpg',
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_a_brand()
    {
        $response = $this->delete('/api/brands/1');

        $response->assertStatus(204);
    }
}
