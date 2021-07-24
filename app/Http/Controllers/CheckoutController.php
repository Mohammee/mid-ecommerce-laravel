<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    public function index()
    {
        if(Cart::instance('default')->count() == 0 )
        {
            return  redirect()->route('shop.index');
        }

        if(auth()->check() && request()->is('guestCheckout'))
        {
            return redirect()->route('checkout.index');
        }


        return view('checkout')
            ->with([
                'discount' => getNumbers()->get('discount'),
                'newSubtotal' => getNumbers()->get('newSubtotal'),
                'newTax' =>getNumbers()->get('newTax'),
                'newTotal' =>getNumbers()->get('newTotal')
            ]);
    }

    public function store(CheckoutRequest $request)
    {
        //check race condition when there are less items available to purchase
        if($this->productAreNotLongerAvailable())
        {
            return back()->withErrors('Sorry! One of the item in your cart no longer available.');
        }

        $contents = Cart::instance('default')->content()->map(function ($item) {
            return $item->model->slug . ', ' . $item->qty;
        })->values()->toJson();

        try {

            $charge = Stripe::charges()->create([
//                'customer' => 'cus_4EBumIjyaKooft',
                'currency' => 'USD',
                'amount' => getNumbers()->get('newTotal'),
                'source' => $request->stripeToken,
                'description' => 'Orders',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                    'coupon' => session('coupon') ? collect(session('coupon'))->toJson() : null
                ],
            ]);

            //insret into order database
            $order = $this->addToOrdersTables($request , null);

            //send order placed email
            Mail::send(new OrderPlaced($order));

            //Decrease product quantity
            $this->decreaseQuantities();

            //Successful && empty cart && session('coupon')
            Cart::instance('default')->destroy();
            if(session()->has('coupon'))
            {
                session()->forget('coupon');
            }

            return redirect()->route('confirmation.index')
                ->with('success_message', 'Thanke you! Your payment has been successfully accepted :)');
        } catch (CardErrorException $e) {

            //insret into order database
            $this->addToOrdersTables($request , $e->getMessage());

            return redirect()->back()
                ->withErrors('Errors! ' . $e->getMessage());
        }
    }


    /**
     * @param  $request
     *  @param  $error
     */
    protected function addToOrdersTables($request , $error)
    {
        $order = Order::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_phone' => $request->phone,
            'billing_postalcode' => $request->postalcode,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => getNumbers()->get('discount'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => getNumbers()->get('newSubtotal'),
            'billing_tax' => getNumbers()->get('newTax'),
            'billing_total' => getNumbers()->get('newTotal'),
            'error' => $error
        ]);

        //insert into order_porduct
        foreach (Cart::instance('default')->content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty
            ]);
        }

        return $order;
    }

    protected function decreaseQuantities()
    {
        foreach(Cart::content() as $item)
        {
            $prodcut = Product::find($item->model->id);
            $prodcut->update([
                'quantity' => $prodcut->quantity - $item->qty
            ]);
        }
    }

    protected function productAreNotLongerAvailable()
    {
        foreach(Cart::content() as $item)
        {
            $product = Product::find($item->model->id);
            if($product->quantity < $item->qty)
            {
                return true;
            }

            return false;
        }
    }

}
