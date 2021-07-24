<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class SaveForLaterController extends Controller
{

    public function destroy($id)
    {
        Cart::instance('saveForLater')->remove($id);
        return back()->with('success_message', 'Item Removed Successfully!!');
    }

    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);
        Cart::instance('saveForLater')->remove($id);

        if (checkDuplicate($item->model)) {
            return redirect()->route('cart.index')
                ->with('success_message', 'The Item is already saved in your cart!!');
        }


        Cart::instance('default')
            ->add(['id' => $item->id, 'name' => $item->name, 'qty' => 1, 'price' => $item->price])
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')
            ->with('success_message', 'Item have been moved to cart!!');
    }

}
