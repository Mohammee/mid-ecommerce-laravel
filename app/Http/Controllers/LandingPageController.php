<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    public function index()
    {
        $products = Product::where('featured' , true)->withRandomProduct(8)->get();
        return view('landing-page')->with('products' , $products);
    }
}
