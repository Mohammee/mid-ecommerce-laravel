<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //laptops
        for ($i = 1; $i <= 30; $i++) {
            Product::create([

                'name' => 'Laptop-' . $i,
                'slug' => 'laptop-' . $i,
                'details' =>  [13,14,15][array_rand([13,14,15])] . ' inch, 1TB SSD,  ' . [8,16,32][array_rand([8,16,32])] . ' GB RAM , coreI' .  [3,5,7][array_rand([3,5,7])] ,
                'price' => rand(99999, 299999) / 100,
                'description' => 'Lorem Ipsum is simply dummy text
                 of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy',
                'image' => 'products/dummy/' . 'laptop-' . $i . '.jpg',
                'images' => '["products\/dummy\/laptop-2.jpg","products\/dummy\/laptop-3.jpg","products\/dummy\/laptop-4.jpg"]'
            ])->category()->attach(1);
        }

         Product::find(1)->category()->attach(2);
         Product::find(2)->category()->attach(2);
        //Desktop
        for ($i = 1; $i <= 9; $i++) {
            Product::create([

                'name' => 'Desktop-' . $i,
                'slug' => 'desktop-' . $i,
                'details' =>  [17,18,19][array_rand([17,18,19])] . ' inch, 1TB SSD,  ' . [8,16,32][array_rand([8,16,32])] . ' GB RAM , coreI' .  [3,5,7][array_rand([3,5,7])] ,
                'price' => rand(199999, 259999) / 100,
                'description' => 'Lorem Ipsum is simply dummy text
                 of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy',
                'image' => 'products/dummy/' . 'desktop-' . $i . '.jpg',
                'images' => '["products\/dummy\/desktop-1.jpg","products\/dummy\/laptop-3.jpg","products\/dummy\/laptop-4.jpg"]',
            ])->category()->attach(2);
        }


        //Phone
        for ($i = 1; $i <= 9; $i++) {
            Product::create([

                'name' => 'Phone-' . $i,
                'slug' => 'phone-' . $i,
                'details' =>  [3,4,5][array_rand([3,4,5])] . ' inch, ' .  [16,32,64][array_rand([16,32,64])]  . ',  ' .  [4,8,12][array_rand([4,8,12])] . ' GB RAM',
                'price' => rand(99999, 139999) / 100,
                'description' => 'Lorem Ipsum is simply dummy text
                 of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy',
                'image' => 'products/dummy/' . 'phone-' . $i . '.jpg',
                'images' => '["products/dummy/desktop-1.jpg","products/dummy/phone-1.jpg","products/dummy/laptop-1.jpg"]'
            ])->category()->attach(3);
        }


        // Tablets
        for ($i = 1; $i <= 9; $i++) {
            Product::create([
                'name' => 'Tablet ' . $i,
                'slug' => 'tablet-' . $i,
                'details' => [16, 32, 64][array_rand([16, 32, 64])] . 'GB, 5.' . [10, 11, 12][array_rand([10, 11, 12])] . ' inch screen, 4GHz Quad Core',
                'price' => rand(49999, 149999)/100,
                'description' => 'Lorem ' . $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/dummy/' . 'tablet-' . $i . '.jpg',
                'images' => '["products/dummy/desktop-1.jpg","products/dummy/phone-1.jpg.jpg","products/dummy/laptop-1.jpg.jpg"]'
            ])->category()->attach(4);
        }

        // TVs
        for ($i = 1; $i <= 9; $i++) {
            Product::create([
                'name' => 'TV ' . $i,
                'slug' => 'tv-' . $i,
                'details' => [46, 50, 60][array_rand([7, 8, 9])] . ' inch screen, Smart TV, 4K',
                'price' => rand(79999, 149999)/100,
                'description' => 'Lorem ' . $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/dummy/' . 'tv-' . $i . '.jpg',
                'images' => '["products/dummy/desktop-1.jpg","products/dummy/phone-1.jpg","products/dummy/laptop-1.jpg"]'
            ])->category()->attach(5);
        }

        // Cameras
        for ($i = 1; $i <= 9; $i++) {
            Product::create([
                'name' => 'Camera ' . $i,
                'slug' => 'camera-' . $i,
                'details' => 'Full Frame DSLR, with 18-55mm kit lens.',
                'price' => rand(79999, 249999)/100,
                'description' => 'Lorem ' . $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/dummy/' . 'camera-' . $i . '.jpg',
                'images' => '["products/dummy/desktop-1.jpg","products/dummy/phone-1.jpg","products/dummy/laptop-1.jpg"]'
                ])->category()->attach(6);
        }

        // Appliances
        for ($i = 1; $i <= 9; $i++) {
            Product::create([
                'name' => 'Appliance ' . $i,
                'slug' => 'appliance-' . $i,
                'details' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis, dolorum!',
                'price' => rand(79999, 149999)/100,
                'description' => 'Lorem ' . $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'image' => 'products/dummy/' . 'appliance-' . $i . '.jpg',
                'images' => '["products/dummy/desktop-1.jpg","products/dummy/phone-1.jpg","products/dummy/laptop-1.jpg"]'
            ])->category()->attach(7);
        }


        Product::whereIn('id' , [2,33,44,53,66,72,80,25,37])->update(['featured' => true]);


//        for ($i = 1  ; $i < 84 ; $i++)
//        {
//          $product=   Product::firstWhere('id' , $i);
//            $product->update([
//                'image' => 'products/May2021/' . $product->slug . '.jpg'
//            ]);
//        }


    }
}
