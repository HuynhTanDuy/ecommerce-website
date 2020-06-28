<?php

namespace App\Jobs;

use App\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class UpdateCoupon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $coupon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Auth::user()) {
            $user_id=Auth::user()->id;
        }
        else $user_id=0;
        session()->put('coupon', [
            'name' => $this->coupon->code,
            'discount' => $this->coupon->discount(Cart::getSubtotal($user_id))
        ]);
        
    }
}
