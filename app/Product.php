<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //use SearchableTrait, Searchable;

    protected $fillable = ['name','slug', 'price', 'details', 'description', 'featured', 'quantity','image', 'images', 'id_store'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 2,
        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function presentPrice()
    {
        return '$'.number_format($this->price / 100, 2);
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $extrasFields);
    }

    public static function getListProduct($user_id)
    {
        $data=DB::select('select products.*,cart_detail.quantity as quantity_cart from products join cart_detail on products.id=cart_detail.id_product join cart on cart_detail.id_cart=cart.id where cart.id_user = ? and cart_detail.status=1',[$user_id]);
        return $data;
    }

    public static function getSaveForLaterProduct($user_id)
    {
        $data=DB::select('select products.*,cart_detail.quantity as quantity_cart from products join cart_detail on products.id=cart_detail.id_product join cart on cart_detail.id_cart=cart.id where cart.id_user = ? and cart_detail.status=0',[$user_id]);
        return $data;
    }

    public static function updateQuantityCart($user_id, $product_id, $quantity)
    {   
        $cart_id = DB::select("select id from cart where id_user = ?",[$user_id]);
        $data_id = DB::update('update cart_detail set quantity = ? where id_cart= ? and id_product = ?',[$quantity,$cart_id[0]->id,$product_id]);
        $data = DB::select('select cart_detail.*,products.price from cart_detail join products on cart_detail.id_product=products.id where cart_detail.id_cart = ? and cart_detail.id_product = ?', [$cart_id[0]->id, $product_id]);
        return $data[0];
    }

    public static function updateQuantity($product_id, $sub) 
    {
        $update = DB::update("update products set quantity = ? where id= ?", [$sub, $product_id]);
        return $update;
    }
}
