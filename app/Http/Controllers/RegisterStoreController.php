<?php

namespace App\Http\Controllers;
use App\Category;
use App\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterStoreController extends Controller
{
    public function index() {
        $categories = Category::all();
        $user = auth()->user();
        return view('Store.register-store')->with([
            'user' => $user,
            'categories' => $categories
        ]);
    }

    public function register(Request $request) {
        $is_existed_store = Store::where('id_owner', auth()->user()->id)->first();
        if ($is_existed_store) {
            return back()->withErrors('Bạn đã đăng kí mở cửa hàng rồi, vui lòng chờ quản trị viên xét duyệt!');
        }
        $store = Store::create([
            'category' => $request->category,
            'id_license' => $request->id_license,
            'id_owner' => auth()->user()->id,
            'location' => $request->location,
            'name' => $request->name_store,
            'status' => 0
        ]);

        return redirect()->route('store.register-info')
        ->with('success_message', 'Đăng kí mở cửa hàng thành công, vui lòng xem lại thông tin đã đăng kí và chờ xét duyệt!');
        
    }

    public function registerInfo() {
        $categories = Category::all();
        $store = Store::where('id_owner', auth()->user()->id)->first();
        if ($store) {
            $category = Category::where('id',  $store->category)->first();
        } else {
            return view('Store.register-store')->with([ 'user' => auth()->user(), 'categories' => $categories])->withErrors('Bạn chưa đăng kí mở cửa hàng');
        }
        return view('Store.register-info')->with([
            'user' => auth()->user(),
            'store' => $store,
            'category' => $category
        ]);
    }

}
