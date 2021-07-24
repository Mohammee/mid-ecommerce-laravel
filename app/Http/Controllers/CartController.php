<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {

        $mightAlsoLike = Product::withRandomProduct(4)->get();

        return view('cart')
            ->with(['mightAlsoLike' => $mightAlsoLike,
                'discount' => getNumbers()->get('discount'),
                'newSubtotal' => getNumbers()->get('newSubtotal'),
                'newTax' => getNumbers()->get('newTax'),
                'newTotal' => getNumbers()->get('newTotal')
            ]);
    }


    public function create()
    {
        //
    }


    public function store(Product $product)
    {

        //method checkDuplicate in helpers.php
        if (checkDuplicate($product)) {
            return redirect()->route('cart.index')
                ->with('success_message', 'The Item is exists in the cart!!');
        }

//          $cart = new \App\Http\Cart(session('carts'));
//         $cart->addToCart($product );
//         $cart->addToCart($product );
//         $cart->update($product , 3);
//         $cart->addToCart(Product::find(1));
//         $cart->removeItem(1);

//         session()->put('carts' , $cart);
// //          dd(session('carts'));
//          $cart = new \App\Http\Cart(session('carts'));

//          dd($cart);

        Cart::instance('default')->add($product->id, $product->name, 1, $product->price)
            ->associate('App\Models\Product');


        return redirect()->route('cart.index')
            ->with('success_message', 'Item was added to your cart!');
    }


    public function show(Product $product)
    {

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('errors', collect(['Quantity be between 1 and 5.']));
            return response()->json(['success' => false], 400);
        }

        if($request->productQuantity < $request->quantity)
        {
           session()->flash('errors' , collect(['We currently don\'t have enough items in stock.']));
           return response()->json(['success' => false] , 400);
        }

        Cart::instance('default')->update($id, $request->quantity);


        session()->flash('success_message', 'Quantity was updated successfully!');

        return response()->json(['success' => true ,
            'hascoupon' => session()->has('coupon'),
            'subtotal' => formatPrice(Cart::instance('default')->subtotal()),
            'discount' => formatPrice(getNumbers()->get('discount')),
            'newSubtotal' => formatPrice(getNumbers()->get('newSubtotal')),
            'newTax' => formatPrice(getNumbers()->get('newTax')),
            'newTotal' => formatPrice(getNumbers()->get('newTotal'))]);
    }

    public function destroy($id)
    {
        Cart::instance('default')->remove($id);
        return back()->with('success_message', 'Item Removed Successfully!!');
    }


    public function switchToSaveForLater($id)
    {
        $item = Cart::instance('default')->get($id);
        Cart::instance('default')->remove($id);

        if (checkDuplicate($item->model, 'saveForLater')) {
            return redirect()->route('cart.index')
                ->with('success_message', 'The Item is already saved for later!!');
        }


        Cart::instance('saveForLater')
            ->add(['id' => $item->id, 'name' => $item->name, 'qty' => 1, 'price' => $item->price])
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')
            ->with('success_message', 'Item was saved for later!!');
    }
}
