<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteCheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::guard('users')->user();
        $old_carts = $user->cart;

        if ($old_carts->isEmpty()) {
            return redirect()->back()->with('status', "Không thể thanh toán khi giỏ hàng trống!!");
        }
        foreach ($old_carts as $cart) {
            if ($cart->product->qty < $cart->qty) {
                $cart->delete();
            }
        }
        $carts = Carts::where('user_id', Auth::guard('users')->user()->id)->get();

        return view('frontend.checkout.index', compact('user', 'carts'));
    }
    public function placeorder(Request $request)
    {
        $order = new Order();
        $timestamp = strtotime(now());
        $order->code = (string)$timestamp;
        $order->user_id = Auth::guard('users')->user()->id;
        $deliveryaddress = $request->address . ', ' . $request->ward . ', ' .  $request->district  . ', ' . $request->province;
        $order->deliveryaddress = $deliveryaddress;
        $order->deliveryname = $request->name;
        $order->deliveryphone = $request->phone;
        $order->deliveryemail = $request->email;
        $order->exportdate = date('Y-m-d H:i:s');
        $order->status = 0;
        $order->save();
        $carts = Carts::where('user_id', Auth::guard('users')->user()->id)->get();
        foreach ($carts as $cart) {
            $orderdetail = new Orderdetail();
            $orderdetail->order_id = $order->id;
            $orderdetail->product_id = $cart->product_id;
            $orderdetail->qty = $cart->qty;

            $product = $cart->product;
            $product_price = $product->price; // Định nghĩa giá trị mặc định cho biến $product_price
            if ($product->sale->price_sale != null) {
                $now = now();
                if ($product->sale->date_begin < $now && $now < $product->sale->date_end) {
                    $product_price = $product->sale->price_sale;
                }
            }
            $orderdetail->price = $product_price;
            $orderdetail->amount = $product_price * $cart->qty;
            $orderdetail->save();
            $product = Product::where('id', $cart->product_id)->first();
            $product->qty -= $cart->qty;
            $product->save();
        }
        $carts = Carts::where('user_id', Auth::guard('users')->user()->id)->get();
        foreach ($carts as $cart) {
            $cart->delete();
        }
        return redirect()->route('site.ordercomplete')->with('alert', "Bây giờ bạn cần thanh toán sớm nhất để hàng được đóng gói và vận chuyển!!");
    }
    public function ordercomplete()
    {
        return view('frontend.checkout.ordercomplete');
    }
}
