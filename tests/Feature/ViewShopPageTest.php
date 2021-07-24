<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewShopPageTest extends TestCase
{

    use RefreshDatabase;
    /**
     *@test
     */
    public function shop_page_laods_correctlly()
    {
        $response = $this->get('/shop');
        $response->assertSee('Featured');
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
        $response = $this->get('/shop');

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
        $response = $this->get('/shop');

        //Assert
        $response->assertDontSee($product->name);
        $response->assertStatus(200);
    }

    /**
     *@test
     */
    public function pagination_for_producs_works()
    {
        //Arrange
        for($i = 11 ; $i < 29 ; $i++)
        {
            Product::factory()->create([
                'name' => 'Product ' . $i,
                'featured' => true
            ]);
        }

        //Act
        $response = $this->get('/shop');

        //Assert
        $response->assertSee('Product 12');
        $response->assertSee('Product 19');

        //Act
        $response = $this->get('/shop?page=2');

        //Assert
        $response->assertSee('Product 20');
        $response->assertSee('Product 28');

    }

   /** @test */
   public function sort_product_low_to_high()
   {
       Product::factory()->create([
           'name' => 'Low Product',
           'price' => 1000,
           'featured' => true
       ]);
       Product::factory()->create([
           'name' => 'Middle Product',
           'price' => 1500,
           'featured' => true
       ]);
       Product::factory()->create([
           'name' => 'High Product',
           'price' => 2000,
           'featured' => true
       ]);

       $response = $this->get('/shop?sort=low_high');
       $response->assertSeeInOrder([
           'Low Product' , 'Middle Product' , 'High Product'
       ]);
   }

    /** @test */
    public function sort_product_high_to_low()
    {
        Product::factory()->create([
            'name' => 'Low Product',
            'price' => 1000,
            'featured' => true
        ]);
        Product::factory()->create([
            'name' => 'Middle Product',
            'price' => 1500,
            'featured' => true
        ]);
        Product::factory()->create([
            'name' => 'High Product',
            'price' => 2000,
            'featured' => true
        ]);

        $response = $this->get('/shop?sort=high_low');
        $response->assertSeeInOrder([
            'High Product' , 'Middle Product' , 'Low Product'
        ]);
    }

    /** @test */
    public function category_page_show_products_correct()
    {
     //Arrange
        $laptop1 = Product::factory()->create(['name' => 'Laptop 1']);
        $laptop2 = Product::factory()->create(['name' => 'Laptop 2']);

        $laptopCategory = Category::create([
            'name' => 'Laptop',
            'slug' =>  'laptop'
        ]);

        $laptopCategory->products()->attach([$laptop1->id , $laptop2->id]);

        //Act
        $response = $this->get('/shop?category=laptop');

        //Assert
        $response->assertSee($laptop1->name);
        $response->assertSee($laptop2->name);

    }


    /** @test */
    public function category_page_does_not_show_products_in_another_category()
    {
        //Arrange
        $laptop1 = Product::factory()->create(['name' => 'Laptop 1']);
        $laptop2 = Product::factory()->create(['name' => 'Laptop 2']);

        $laptopCategory = Category::create([
            'name' => 'Laptop',
            'slug' =>  'laptop'
        ]);

        $laptopCategory->products()->attach([$laptop1->id , $laptop2->id]);

        //Arrange
        $desctop1 = Product::factory()->create(['name' => 'Desctop 1']);
        $desctop2 = Product::factory()->create(['name' => 'Desctop 2']);

        $desctopCategory = Category::create([
            'name' => 'Desctop',
            'slug' =>  'desctop'
        ]);

        $desctopCategory->products()->attach([$desctop1->id , $desctop2->id]);

        //Act
        $response = $this->get('/shop?category=laptop');

        //Assert
        $response->assertDontSee($desctop1->name);
        $response->assertDontSee($desctop2->name);

    }
}
