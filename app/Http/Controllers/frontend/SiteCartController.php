<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteCartController extends Controller
{
    public function addcart(Request $request)
    {
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');

        if (Auth::guard('users')->check()) {
            $product_check = Product::where('id', $product_id)->first();
            if ($product_check != null) {
                $cart_check = Carts::where([['product_id', $product_id], ['user_id', Auth::guard('users')->user()->id]])->exists();
                if ($cart_check) {
                    return response()->json(['status' => 'Đã thêm ' . $product_check->name . ' trước đó']);
                } else {
                    $cart = new Carts();
                    $cart->user_id = Auth::guard('users')->user()->id;
                    $cart->product_id = $product_id;
                    $cart->qty = $qty;
                    $cart->save();
                    return response()->json(['status' => 'Đã thêm ' . $product_check->name . ' vào giỏ hàng']);
                }
            } else {
                return response()->json(['status' => 'Sản phẩm không tồn tại']);
            }
        } else {
            return response()->json(['status' => 'Bạn cần đăng nhập trước']);
        }
    }
    public function showcarts()
    {
        $title = "Giỏ Hàng";
        $carts = Carts::where('user_id', Auth::guard('users')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('frontend.show_carts', compact('title', 'carts'));
    }
}
