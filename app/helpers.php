<?php


if (!function_exists('checkDuplicate')) {
    function checkDuplicate($product, $instance = 'default')
    {
        $duplicates = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        return $duplicates->isNotEmpty() ? true : false;

    }
}


if (!function_exists('setActiveCategory')) {
    function setActiveCategory($category, $output = 'active')
    {
        return request()->category == $category->slug ? $output : '';
    }
}


if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return number_format($price, 2);
    }
}


if (!function_exists('productImage')) {
    function productImage($path)
    {
        return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('img/not-found.jpg');
    }
}

if (!function_exists('getNumber')) {
    function getNumbers()
    {
        $tax = config('cart.tax') / 100;

        $code = session()->has('coupon') ? session('coupon')['code'] : null;
        $discount = session('coupon') ? session('coupon')['discount'] : 0;
        $newSubtotal = (Cart::subtotal() - $discount);

        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        $newTax = $tax * $newSubtotal;
        $newTotal = $newSubtotal * (1 + $tax);

        return collect([
            'code' => $code,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal
        ]);
    }
}
if (!function_exists('getStockLevel')) {
    function getStocklevel($quantity)
    {
        if (setting('site.stock_threshold', 5) < $quantity) {
            $stockLevel = '<div class="badge badge-success">In Stock</div>';
        } elseif (setting('site.stock_threshold', 5) >= $quantity && $quantity > 0) {
            $stockLevel = '<div class="badge badge-warning">Low Stock</div>';
        } else {
            $stockLevel = '<div class="badge badge-danger">Not Available</div>';
        }
        return $stockLevel;

    }
}

if (!function_exists('presentDate')) {
    function presentDate($date)
    {
         //return date('M d , Y' , strtotime($date));
        //don't forgot add created_at and updated_at in protected $dates = [] in model
        return $date->format('M d, Y'); // this work as Carbon::parse($date)->format('M d, Y');
    }
}
