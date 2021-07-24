<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelpersTest extends TestCase
{

    /** @test */
    public function can_get_formatted_price()
    {
     $product = Product::factory()->make([
         'name' => 'Laptop 1' ,
         'price' => 2999
     ]);

     $this->assertEquals('2,999.00' , formatPrice($product->price));
    }
}
