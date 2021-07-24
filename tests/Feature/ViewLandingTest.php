<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewLandingTest extends TestCase
{

    use RefreshDatabase;
    /**
     *@test
     */
    public function lading_page_laods_correctlly()
    {
        $response = $this->get('/');
        $response->assertSee('Ecommerce');
        $response->assertStatus(200);
     }

    /**
     *@test
     */
    public function featured_product_visibale()
    {
        //Arrange
        $product = Product::factory()->create([
            'name' => 'Laptop-1',
            'featured' => true
        ]);

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertSee($product->name);
        $response->assertStatus(200);
    }

    /**
     *@test
     */
    public function non_featured_product_not_visibale()
    {
        //Arrange
        $product = Product::factory()->create([
            'name' => 'Laptop-1',
            'featured' => false
        ]);

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertDontSee($product->name);
        $response->assertStatus(200);
    }
}
