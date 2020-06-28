<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $table = 'cart';

    public static function addToCart($user_id, $product_id)
    {
    	$check=DB::select('select * from cart_detail join cart on cart.id=cart_detail.id_cart where id_user = ? and id_product= ?', [$user_id,$product_id]);
    	$id_cart=DB::select('select * from cart where id_user=?',[$user_id]);
    	if (empty($check)) {
    		$data=DB::insert('insert into cart_detail (id_product, id_cart, status) value (?,?,?)',[$product_id, $id_cart[0]->id, 1]);
    	}
    	else {
    		$data=null;
    	}  	
    	return $data;
    }

    public static function removeItem($product_id, $user_id) 
    {   
        $cart_id = DB::select("select id from cart where id_user = ?",[$user_id]);
        $delete = DB::delete('delete from cart_detail where id_product=? and id_cart=?', [$product_id, $cart_id[0]->id]);
        return $delete;
    }

    public static function updateStatus($product_id
        , $user_id , $status)
    {
        $cart_id = DB::select("select id from cart where id_user = ?",[$user_id]);
        $update = DB::update('update cart_detail set status = ? where id_product=? and id_cart=?', [$status, $product_id, $cart_id[0]->id]);
        return $update;
    }

    public static function getSubtotal($user_id)
    {
        $cart_id = DB::select("select id from cart where id_user = ?",[$user_id]);
        $data = DB::select("select products.price, cart_detail.quantity from cart_detail join products on cart_detail.id_product=products.id where cart_detail.id_cart = ? and cart_detail.status=1",[$cart_id[0]->id]);
        $subtotal=0;
        foreach ($data as $item) {
            $subtotal += ($item->price * $item->quantity);
        }
        return $subtotal;
    }

    public static function clearAfterOrder($user_id)
    {
        $cart_id = DB::select("select id from cart where id_user = ?",[$user_id]);
        $delete = DB::delete('delete from cart_detail where id_cart=?', [$cart_id[0]->id]);
        return $delete;
    }

    public static function createDefaultCart($user_id)
    {
        $data = DB::insert('insert into cart (id_user) value (?)',[$user_id]);
        return $data;
    }   

}
