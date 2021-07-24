<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewProductPageTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_view_product_details()
    {
        //Arrange
     $product = Product::factory()->create([
         'name' => 'Laptop 1',
         'slug' => 'laptop-1',
         'details' => '13.5 inch, 1TB SSD , 16 GB RAM',
         'price' => 2000,
         'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
         'image' => 'products/dummy/laptop-1.jpg',
     ]);

     //Act
     $response = $this->get('/shop/'. $product->slug);

     //Assert
       $response->assertStatus(200);
       $response->assertSee('Laptop 1');
       $response->assertSee('13.5 inch, 1TB SSD , 16 GB RAM');
       $response->assertSee('Lorem ipsum dolor sit amet, consectetur adipisicing elit.');
       $response->assertSee(formatPrice($product->price));

    }

    /** @test */
    public function stock_level_high()
    {
        //Arrange
        $product = Product::factory()->create(['quantity' => 10]);

         //Act
        $response = $this->get('/shop/' . $product->slug);

        //Assert
        $response->assertSee('In Stock');

    }

    /** @test */
    public function stock_level_low()
    {
        //Arrange
        $product = Product::factory()->create(['quantity' => 4]);

        //Act
        $response = $this->get('/shop/' . $product->slug);

        //Assert
        $response->assertSee('Low Stock');

    }

    /** @test */
    public function stock_level_not_available()
    {
        //Arrange
        $product = Product::factory()->create(['quantity' => 0]);

        //Act
        $response = $this->get('/shop/' . $product->slug);

        //Assert
        $response->assertSee('Not Available');

    }

    /** @test */
    public function show_related_product()
    {
     //Arrange
        $product = Product::factory()->create(['name' => 'Laptop 1']);
        $product = Product::factory()->create(['name' => 'Laptop 2']);

        //Act
        $response = $this->get('/shop/' . $product->slug);

        //Assert
        $response->assertSee('Laptop 2');
        $response->assertViewHas('mightAlsoLike');
    }
}

