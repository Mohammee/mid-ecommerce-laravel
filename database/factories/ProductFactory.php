<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'featured' => false,
            'slug' => $this->faker->slug,
            'details' => $this->faker->sentence(8),
            'price' =>$this->faker->numberBetween(100000 , 250000)/100,
            'description' => $this->faker->paragraph,
            'image' => 'products/dummy/' . 'appliance-' . 1 . '.jpg',
        ];
    }
}
