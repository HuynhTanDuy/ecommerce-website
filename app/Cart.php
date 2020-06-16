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
}
