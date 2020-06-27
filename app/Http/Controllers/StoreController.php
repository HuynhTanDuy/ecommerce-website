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

    public function updateProductIndex($id) {
        $product = Product::where('id', $id)->first();
        $images = $product->images;
        $pieces = explode(",", $images);
        $index = 0;
        $img = array();
        foreach($pieces as $p) {
            $img[$index] = str_replace('"', '', $p);
            $img[$index] = str_replace(']', '', $img[$index]);
            $img[$index] = str_replace('[', '', $img[$index]);
            $index++;
        }

        return view('Store.update-product')->with([
            'product' => $product,
            'images' => $img
        ]);
    }

    public function updateProduct(Request $request, $id) {
        $store = Store::where('id_owner', auth()->user()->id)->first();
        $product = Product::where('id', $id)->first();
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'details' => 'string|min:6',
            'price' => 'required|max:255',
            'description' => 'required|string|max:255',
            'quantity' => 'required|max:255',    
            'image' => 'string|max:255',
            'images' => 'string|max:255'
        ]);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->details = $request->details;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->image = $request->image;
        $product->images = $request->images;
        $product->slug = $request->slug;
        $product->save();
        return redirect()->route('store.my-store')->with('success_message', 'Cập nhật sản phẩm thành công');
    }

    public function deleteProduct($id) {
        $store = Store::where('id_owner', auth()->user()->id)->first();
        $product = Product::where('id', $id)->first();
        $product->delete();
        return redirect()->route('store.my-store')->with('success_message', 'Xóa sản phẩm sản phẩm thành công');

    }
}
