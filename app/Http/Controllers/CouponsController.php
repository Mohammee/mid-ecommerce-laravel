<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateCoupon;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponsController extends Controller
{

    public function store(Request $request)
    {
       $code  = $request->coupon_code;
       $coupon = Coupon::findByCode($code);

       if(!$coupon)
       {
           return back()->withErrors('Invalid Coupon code. Please try again !');
       }

       dispatch(new UpdateCoupon($coupon));

       return back()->with('success_message' , 'Coupon has been applied!');

    }


    public function destroy()
    {
       session()->forget('coupon');
        return back()->with('success_message' , 'Coupon has been removed successfully!');
    }
}
