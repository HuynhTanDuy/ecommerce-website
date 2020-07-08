<?php

namespace App\Http\Controllers;
use App\Category;
use App\Store;
use App\Product;
use App\Order;
use Illuminate\Http\Request;
use App\OrderProduct;
use Illuminate\Support\Facades\DB;


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

    public function addProduct(Request $request) {
        $store = Store::where('id_owner', auth()->user()->id)->first();
        //echo $request;
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'details'=>  $request->details,
            'description'=> $request->description,
            'slug' => $request->slug,
            'id_store' => $store->id,
            'quantity' => $request->quantity
            ]);

            if($request->hasFile('image')) {
                $file=$request->file('image');
                $name=$file->getClientOriginalName();
                $avatar=str_random(4)."_". $name;
                $duoi=$file->getClientOriginalExtension();
                while(file_exists("img/products/".$avatar))
                {
                    $avatarHinh=str_random(4)."_".$name;
                }
                $file->move("img/products/",$avatar);
                $product->image=$avatar;
            }
            else {
                $product->image="";
            }
            $array_images = array();
            if($request->hasFile('images')) {
                $images = $request->file('images');
                foreach($images as $image){
                    $name=$image->getClientOriginalName();
                    $image->move('img/products/',$name);
                    $array_images[] = $name;
                }
            }
            $product->images = $array_images;
            
            $product->save();
            Product::addProductCategory($product->id,$store->category);
        return redirect()->route('store.my-store')
        ->with('success_message', 'Thêm sản phẩm mới thành công!');
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
            'quantity' => 'required|max:255'
        ]);
        if($request->hasFile('image')) {
            $file=$request->file('image');
            $name=$file->getClientOriginalName();
            $avatar=str_random(4)."_". $name;
            $duoi=$file->getClientOriginalExtension();
            while(file_exists("img/products/".$avatar))
            {
                $avatarHinh=str_random(4)."_".$name;
            }
            $file->move("img/products/",$avatar);
            $product->image=$avatar;
        }
        else {
            $product->image="";
        }
        $array_images = array();
        if($request->hasFile('images')) {
            $images = $request->file('images');
            foreach($images as $image){
                $name=$image->getClientOriginalName();
                $image->move('img/products/',$name);
                $array_images[] = $name;
            }
        }
        $product->images = $array_images;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->details = $request->details;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
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
	
	public function orderList() {
		$store = Store::where('id_owner', auth()->user()->id)->first();
		$order=DB::select('SELECT DISTINCT orders.* FROM orders JOIN order_product ON orders.id = order_product.order_id 
        JOIN products ON order_product.product_id = products.id WHERE products.id_store = ? AND orders.shipped = ?', [$store->id, 0]);
		return view('Store.order-list')->with([
			'order' => $order
		]);
    }

    public function orderDetail($order_id) {
		$store = Store::where('id_owner', auth()->user()->id)->first();
		$order=DB::select('SELECT * FROM orders JOIN order_product ON orders.id = order_product.order_id 
        JOIN products ON order_product.product_id = products.id
        WHERE order_product.order_id = ?', [$order_id]);
        $products = DB::select('SELECT products.*,order_product.order_quantity FROM products join order_product 
        on order_product.product_id=products.id where order_product.order_id=?', [$order_id]);
        return view('Store.order-detail')->with([
            'order'=> $order[0],
            'products' => $products
        ]);

    }

    public function orderFinish($order_id) {
        $order = Order::where('id', $order_id)->first();
        $order->shipped = 1;
        $order->save();
        return redirect()->route('order.list')->with('success_message', 'Hoàn thành đơn hàng');
    

    }

    public function orderFinished() {
		$store = Store::where('id_owner', auth()->user()->id)->first();
		$order=DB::select('SELECT * FROM orders JOIN order_product ON orders.id = order_product.order_id 
        JOIN products ON order_product.product_id = products.id WHERE products.id_store = ? AND orders.shipped = ?', [$store->id, 1]);
		return view('Store.order-finished')->with([
			'order' => $order
		]);
    }

    public function orderCancel($order_id) {
        $order= Order::where('id', $order_id)->first();
        $order_products = OrderProduct::where('order_id', $order->id)->get();

        $order_products->each->delete();
        $order->delete();
        return redirect()->route('order.list')->with('success_message', 'Hủy đơn hàng thành công');

    }

    public function storeInformation() {

        $store = Store::where('id_owner', auth()->user()->id)->first();
        $category = Category::where('id', $store->category)->first();
        return view('Store.store-information')->with([
            'store' => $store,
            'category' => $category
        ]);
    }

    public function UpdateStoreInformation(Request $request, $id) {
        $store = Store::where('id', $id)->first();
        $store->name = $request->name_store;
        $store->location = $request->location;
        $store->save();
        return redirect()->route('store.information')->with('success_message', 'Cập nhật thành công');
    }
}
