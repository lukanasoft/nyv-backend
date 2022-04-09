<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
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

    public function test_get_all_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_get_a_product()
    {
        $response = $this->get('/api/products/1');

        $response->assertStatus(200);
    }

    public function test_store_a_product()
    {
        $response = $this->post('/api/products', [
            'name' => 'Product 2',
            'code' => 'Product 2',
            'aplication' => 'Product 2',
            'description' => 'Product 2',
            'importance' => 0,
            'brand_id' => '3',
            'category_id' => '8',
            'user_id' => '2',
        ]);

        $response->assertStatus(201);
    }

    //test store a product with photos

    public function test_store_a_product_with_photos()
    {
        $response = $this->post('/api/products/with-photos', [
            'name' => 'Product 2',
            'code' => 'Product 2',
            'aplication' => 'Product 2',
            'description' => 'Product 2',
            'importance' => 0,
            'brand_id' => '3',
            'category_id' =>'8',
            'user_id' => '2',
            'photos' => [
                [
                    'name' => 'Product 1',
                    'url' => 'Product 1 description',
                ],
                [
                    'name' => 'Product 1',
                    'url' => 'Product 1 description',
                ],
            ],
        ]);

        $response->assertStatus(201);
    }

    public function test_update_a_product()
    {
        $response = $this->put('/api/products/1', [
            'name' => 'Product 2',
            'code' => 'Product 2',
            'aplication' => 'Product 2',
            'description' => 'Product 2',
            'importance' => 'Product 2',
            'brand_id' => 3,
            'category_id' => 8,
            'user_id' => 2,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_a_product()
    {
        $response = $this->delete('/api/products/1');

        $response->assertStatus(204);
    }

}
