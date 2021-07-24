<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{

    public function index()
    {
//           DB::listen(function ($query) {
//               logger($query->sql , $query->bindings);
//           });
        $categories = Category::all();
        $paginator = 9;
        if(request()->category)
        {
            $products = Product::whereHas( 'category' , function($query){
                $query->where('slug' , request()->category);
            });

            $categoryName = optional($categories->firstWhere('slug' , request()->category))->name;
        }
        else
        {
            $products = Product::where('featured' , true);
            $categoryName = 'Featured';
        }

        if(request()->sort == 'low_high')
        {
          $products = $products->orderBy('price' )->paginate($paginator);
        }elseif(request()->sort == 'high_low')
        {
            $products = $products->orderBy('price' , 'desc')->paginate($paginator);
        }else{
               $products = $products->paginate($paginator);
        }


        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName
        ]);
    }

    public function show(Product $product)
    {
        $mightAlsoLike = Product::where('slug' , '!=' , $product->slug)
            ->withRandomProduct(4)->get();

        $stockLevel = getStockLevel($product->quantity);

        return view('product')
            ->with(['product' =>  $product,
               'mightAlsoLike' => $mightAlsoLike,
                'stockLevel'=> $stockLevel]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:2'
        ]);

        $query = $request->input('query');
//        $products = Product::where('name' , 'like' , "%{$query}%")
//            ->orWhere('details' , 'like' , "%{$query}%")
//            ->orWhere('description' , 'like' , "%{$query}%")->paginate(10);
        $products = Product::search($query , null , true )->paginate(10);

        return view('search-result')->with(['products' => $products]);
    }

    public function searchAlgolia()
    {
        return view('search-result-algolia');
    }



}
