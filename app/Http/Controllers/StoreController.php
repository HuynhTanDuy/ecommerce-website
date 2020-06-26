<?php

namespace App\Http\Controllers;
use App\Category;
use App\Store;
use App\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index() {
        $store = Store::where('id_owner', auth()->user()->id)->first();
        $products = Product::where('id_store', $store->id)->get();

        return view('Store.my-store')->with([
            'store' => $store,
            'products' => $products
        ]);
    }

    public function addProductIndex() {
        return view('Store.add-product');
    }
}
