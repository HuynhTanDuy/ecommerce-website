<?php

use Carbon\Carbon;
use App\Cart;

function presentPrice($price)
{
    return '$'.number_format($price / 100, 2);
}

function presentDate($date)
{
    return Carbon::parse($date)->format('M d, Y');
}

function setActiveCategory($category, $output = 'active')
{
    return request()->category == $category ? $output : '';
}

function productImage($path)
{
    return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg');
}

function getNumbers()
{
    //$tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $code = session()->get('coupon')['name'] ?? null;
    // $newSubtotal = (Cart::subtotal() - $discount);
    $newSubtotal=1;
    if ($newSubtotal < 0) {
        $newSubtotal = 0;
    }
    //$newTax = $newSubtotal * $tax;
    //$newTotal = $newSubtotal * (1 + $tax);
    if (Auth::user()) {
            $user_id=Auth::user()->id;
        }
    else $user_id=0;
    $sub_total=Cart::getSubtotal($user_id);
    
    $final_total= $sub_total - $discount;
    return collect([
        //'tax' => $tax,
        'discount' => $discount,
        'code' => $code,
        // 'newSubtotal' => $newSubtotal,
        //'newTax' => $newTax,
        //'newTotal' => $newTotal,
        'sub_total' =>$sub_total,
        'final_total' => $final_total
    ]);
}

function getStockLevel($quantity)
{
    if ($quantity > setting('site.stock_threshold', 5)) {
        $stockLevel = '<div class="badge badge-success">In Stock</div>';
    } elseif ($quantity <= setting('site.stock_threshold', 5) && $quantity > 0) {
        $stockLevel = '<div class="badge badge-warning">Low Stock</div>';
    } else {
        $stockLevel = '<div class="badge badge-danger">Not available</div>';
    }

    return $stockLevel;
}
