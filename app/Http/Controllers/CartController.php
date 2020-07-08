<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
// use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Events\Dispatcher;
use App\Coupon;

class CartController extends Controller
{   
    /**
     * Instance of the event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $events;

    public function __construct(Dispatcher $events,Coupon $coupon)
    {
        $this->events = $events;
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Auth::user()) {
            $user_id=Auth::user()->id;
        }
        else $user_id=0;

        $mightAlsoLike = Product::mightAlsoLike()->get();
        $products=Product::getListProduct($user_id);
        $saveForLater=Product::getSaveForLaterProduct($user_id);
        $this->events->dispatch('cart.stored');

        $code = session()->get('coupon')['name'] ?? null;
        if ($code !=null) {
            $coupon = Coupon::findByCode($code);
            if ($coupon->type == 'fixed') {
                $discount = $coupon->value;
            } elseif ($coupon->type == 'percent') {
                $discount= round(($coupon->percent_off / 100) * Cart::getSubtotal($user_id));
            } else {
                $discount = 0;
            }
        }
        else $discount=0;
        return view('cart')->with([
            'mightAlsoLike' => $mightAlsoLike,
            'discount' => $discount,
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
            'products' => $products,
            'saveForLater' => $saveForLater,
            'sub_total' => getNumbers()->get('sub_total'),
            'final_total' => getNumbers()->get('final_total')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product)
    {
        // $duplicates = Cart::search(function ($cartItem, $rowId) use ($product) {
        //     return $cartItem->id === $product->id;
        // });

        // if ($duplicates->isNotEmpty()) {
        //     return redirect()->route('cart.index')->with('success_message', 'Item is already in your cart!');
        // }

        // Cart::add($product->id, $product->name, 1, $product->price)
        //     ->associate('App\Product');

        // return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
        if (Auth::user()) {
            $data = Cart::addToCart(Auth::user()->id, $product->id);
        }
        else $data = Cart::addToCart(0, $product->id);
        return redirect()->back()->with('success_message', 'Sản phẩm đã được thêm vào giỏ hàng!');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('errors', collect(['Quantity must be between 1 and 5.']));
            return response()->json(['success' => false], 400);
        }

        if ($request->quantity > $request->productQuantity) {
            session()->flash('errors', collect(['Cửa hàng tạm hết sản phẩm này.']));
            return response()->json(['success' => false], 400);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Số lượng được cập nhật thành công!');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cart::remove($id);

        // return back()->with('success_message', 'Item has been removed!');

        Cart::removeItem($id, Auth::user()->id);
        return back()->with('success_message', 'Sản phẩm đã được xoá khỏi giỏ hàng!');
    }

    /**
     * Switch item for shopping cart to Save for Later.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToSaveForLater($id)
    {   
        // $item = Cart::get($id);

        // Cart::remove($id);

        // $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {
        //     return $rowId === $id;
        // });

        // if ($duplicates->isNotEmpty()) {
        //     return redirect()->route('cart.index')->with('success_message', 'Item is already Saved For Later!');
        // }

        // Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
        //     ->associate('App\Product');

        $SAVE_FOR_LATER=0;

        Cart::updateStatus($id, Auth::user()->id, $SAVE_FOR_LATER);

        return redirect()->route('cart.index')->with('success_message', 'Sản phẩm được lưu cho lần mua sau!');
    }

    public function switchToCart($id)
    {   
        $MOVE_TO_CART=1;

        Cart::updateStatus($id, Auth::user()->id, $MOVE_TO_CART);

        return redirect()->route('cart.index')->with('success_message', 'Sản phẩm đã được xoá khỏi giỏ hàng!');
    }

    public function updateQuantity(Request $request)
    {   
        if (Auth::user()) {
            $user_id=Auth::user()->id;
        }
        else $user_id=0;

        $data = Product::updateQuantityCart($user_id, $request->product_id, $request->quantity);
        $data->price = presentPrice($data->price * $data->quantity);
        return response()->json([
            'message'=> "success",
            'data' => $data
        ]);
    }
}
