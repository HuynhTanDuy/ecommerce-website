<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Product;
use App\User;
use App\Store;
class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = auth()->user()->orders; // n + 1 issues

       $orders_finished = Order::where(['user_id' => auth()->user()->id, 'shipped' => 1])->get();
       $orders_delivering = Order::where(['user_id' => auth()->user()->id, 'shipped' => 0])->get();

       return view('my-orders')->with([
           'orders_finished'=> $orders_finished,
           'orders_delivering' => $orders_delivering
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=DB::select('SELECT * FROM orders JOIN order_product ON orders.id = order_product.order_id 
        JOIN products ON order_product.product_id = products.id
        WHERE order_product.order_id = ?', [$id]);
        $products = DB::select('SELECT products.*,order_product.order_quantity FROM products join order_product 
        on order_product.product_id=products.id where order_product.order_id=?', [$id]);

        $total=0;
        foreach ($products as $item) {
            $total+= ($item->price * $item->order_quantity);
        }
        return view('my-order')->with([
            'order'=> $order[0],
            'products' => $products,
            'total' => $total
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test()
    {
        return User::create([
            'name' =>'user_test1',
            'email' => 'testemail',
            'password' => bcrypt('123456'),
        ]);
        return $product;
    }
}
