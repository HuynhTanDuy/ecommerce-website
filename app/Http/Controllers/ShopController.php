<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Store;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 9;
        $categories = Category::all();

        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
        } else {
            $products = Product::where('featured', true);
            $categoryName = 'Nổi bật';
        }

        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate($pagination);
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc')->paginate($pagination);
        } else {
            $products = $products->paginate($pagination);
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();

        $stockLevel = getStockLevel($product->quantity);
        $store = Store::where('id', $product->id_store)->firstOrFail();
        $product_store = Product::where('id_store', $store->id)->get();
        $product_count = $product_store->count();
        return view('product')->with([
            'product' => $product,
            'stockLevel' => $stockLevel,
            'mightAlsoLike' => $mightAlsoLike,
            'store' => $store,
            'product_count' => $product_count
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');

        // $products = Product::where('name', 'like', "%$query%")
        //                    ->orWhere('details', 'like', "%$query%")
        //                    ->orWhere('description', 'like', "%$query%")
        //                    ->paginate(10);

        //$products = Product::search($query)->paginate(10);
        $products = Product::where('name', 'LIKE', '%'.$query.'%')->orWhere('slug', 'LIKE', '%'.$query.'%');

        //return view('search-results')->with('products', $products);
        $categories = Category::all();
        $categoryName='Kết quả tìm kiếm';
        $pagination=9;
        $products = $products->paginate($pagination);
        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }

    public function searchAlgolia(Request $request)
    {
        return view('search-results-algolia');
	}
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function shopDetail($id) {
		$pagination = 9;
		$products = Product::where('id_store', $id);
		$store = Store::where('id', $id)->first();
		if (request()->sort == 'low_high') {
			$products = $products->orderBy('price')->paginate($pagination);
        } elseif (request()->sort == 'high_low') {
			$products = $products->orderBy('price', 'desc')->paginate($pagination);
        } else {
            $products = $products->paginate($pagination);
		}
		return view('shop-detail')->with([
			'products' => $products,
			'store' => $store
        ]);
	}
}
