<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersConroller extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        DB::listen(function ($query){
//            logger($query->sql , $query->bindings);
//        });
//        $orders = auth()->user()->orders; // n+1 issues

        $orders = auth()->user()->orders()->with('products')->get(); //fix n+1 issues
        return view('my-orders')
            ->with('orders', $orders);
    }
    /**
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if($order->user_id !== auth()->id())
        {
            return back()->withErrors('You can\'t access this order.');
        }

        return view('my-order')->with([
            'order' => $order,
            'products' => $order->products
        ]);
    }
}


