<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_all_categories()
    {
        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    public function test_get_a_category()
    {
        $response = $this->get('/api/categories/1');

        $response->assertStatus(200);
    }

    public function test_store_a_category()
    {
        $response = $this->post('/api/categories', [
            'name' => 'Category 1',
        ]);

        $response->assertStatus(201);
    }

    public function test_store_a_category_with_recursive_relationship()
    {
        $response = $this->post('/api/categories', [
            'name' => 'Category 2',
            'category_id' => 8,
        ]);

        $response->assertStatus(201);
    }

    public function test_update_a_category()
    {
        $response = $this->put('/api/categories/1', [
            'name' => 'Category 1',
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_a_category()
    {
        $response = $this->delete('/api/categories/1');

        $response->assertStatus(204);
    }
}
