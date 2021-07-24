<?php

namespace App\Listeners;

use App\Jobs\UpdateCoupon;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartUpdatedListeners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       $couponCode = session('coupon') ? session()->get('coupon')['code'] : null;

     if($couponCode){

         $coupon = Coupon::findByCode($couponCode);

         dispatch(new UpdateCoupon($coupon));

     }
    }
}
