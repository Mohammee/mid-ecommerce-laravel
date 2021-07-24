<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/' , [\App\Http\Controllers\LandingPageController::class , 'index'])->name('landing-page');
Route::get('/shop' , [\App\Http\Controllers\ShopController::class , 'index'])->name('shop.index');
Route::get('/shop/{product:slug}' , [\App\Http\Controllers\ShopController::class , 'show'])->name('shop.show');


Route::group(['prefix' => 'cart' , 'as' => 'cart.'] , function(){
    Route::get('/' , [\App\Http\Controllers\CartController::class , 'index'])->name('index');
    Route::post('/{product}' , [\App\Http\Controllers\CartController::class , 'store'])->name('store');
    Route::patch('/{product}' , [\App\Http\Controllers\CartController::class , 'update'])->name('update');
    Route::delete('/{prodcut}' , [\App\Http\Controllers\CartController::class , 'destroy'])->name('destroy');
    Route::post('switchToSaveForLater/{product}' , [\App\Http\Controllers\CartController::class , 'switchToSaveForLater'])
        ->name('switchToSaveForLater');
});


Route::delete('SaveForLater/{prodcut}' , [\App\Http\Controllers\SaveForLaterController::class , 'destroy'])
    ->name('saveForLater.destroy');
Route::post('saveForLater/switchToCart/{product}' , [\App\Http\Controllers\SaveForLaterController::class , 'switchToCart'])
    ->name('saveForLater.switchToCart');

Route::get('/checkout'  , [\App\Http\Controllers\CheckoutController::class , 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout'  , [\App\Http\Controllers\CheckoutController::class , 'store'])->name('checkout.store');


Route::get('/guestCheckout'  , [\App\Http\Controllers\CheckoutController::class , 'index'])->name('guestCheckout.index');



Route::post('/coupon' , [\App\Http\Controllers\CouponsController::class , 'store'])->name('coupon.store');
Route::delete('/coupon' , [\App\Http\Controllers\CouponsController::class , 'destroy'])->name('coupon.destroy');

Route::get('/thankyou' , [\App\Http\Controllers\ConfirmationController::class , 'index'])->name('confirmation.index');
Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/search' , [\App\Http\Controllers\ShopController::class , 'search'])->name('search');

Route::get('/search-algolia' , [\App\Http\Controllers\ShopController::class , 'searchAlgolia'])->name('search-algolia');


Route::middleware('auth')->group(function () {
    Route::get('/my-profile' , [\App\Http\Controllers\UsersContorller::class , 'edit'] )->name('users.edit');
    Route::patch('/my-profile' , [\App\Http\Controllers\UsersContorller::class , 'update'] )->name('users.update');
    Route::get('/my-orders' , [\App\Http\Controllers\OrdersConroller::class , 'index'] )->name('orders.index');
    Route::get('/order/{order}' , [\App\Http\Controllers\OrdersConroller::class , 'show'] )->name('order.show');
});



//Route::get('/mailable' , function (){
//    $order = \App\Models\Order::find(4);
//
//    return new \App\Mail\OrderPlaced($order);
//});

//Route::get('/sendeamil' , function (){
//    \Illuminate\Support\Facades\Mail::raw('From mohammas sultan ' , function ($message) {
//        $message->to('mohammeed204@gmail.com')
//            ->subject('Hi man')
//            ->from('mohammeed204@gmail.com' , 'Ecommerce App');
//    });
//});
