<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Orderdetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::join('orderdetail', 'orderdetail.order_id', '=', 'order.id')
            ->join('user', 'user.id', '=', 'order.user_id')
            ->OrderBy('order.created_at', 'desc')
            ->select('user.name as user_name', 'user.email as user_email', 'user.phone as user_phone', 'order.*')
            ->distinct()
            ->get();

        $list_status = [
            ['type' => 'secondary', 'text' => 'Đơn hàng mới'],
            ['type' => 'primary', 'text' => 'Đã xác nhận'],
            ['type' => 'info', 'text' => 'Đóng gói'],
            ['type' => 'warning', 'text' => 'Vận chuyển'],
            ['type' => 'success', 'text' => 'Đã giao'],
            ['type' => 'danger', 'text' => 'Đã hủy'],
        ];
        $title = 'Tất Cả Đơn Hàng';
        return view("backend.order.index", compact('order', 'title', 'list_status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function status(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => 'Sản phẩm không tồn tại']);
        } else {
            $type = $request->status;
            switch ($type) {

                case 'xacnhan': {
                        $order->status = 1;
                        break;
                    }
                case 'donggoi': {
                        $order->status = 2;
                        break;
                    }
                case 'vanchuyen': {
                        $order->status = 3;
                        break;
                    }
                case 'dagiao': {
                        $order->status = 4;
                        break;
                    }
                case 'huy': {
                        $order->status = 5;
                        break;
                    }
            }
            $order->updated_at = date('Y-m-d H:i:m');
            $order->updated_by = 1;
            $order->save();
            return redirect()->route('order.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $title = 'Chi tiết hóa đơn';
        $order = Order::find($id);
        $list_orderdetail = $order->orderdetail;
        $user = $order->user;



        // $orderdetail=Orderdetail::where('')
        // $list_orderdetail=Product::where('id','=',$order->)
        // $list_orderdetail = Product::join('Orderdetail', 'product.id', '=', 'orderdetail.product_id')
        //     ->join('product_sale', 'product.id', '=', 'product_sale.product_id')
        //     ->select('*',  'product_sale.price_sale as product_price_sale')
        //     ->where('orderdetail.order_id', '=', $id)
        //     ->get();
        $total = $list_orderdetail->sum(function ($sum) {
            return $sum->amount;
        });
        if ($order == null) {
            return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => 'Sản phẩm không tồn tại']);
        }

        return view('backend.order.show', compact('order',  'title', 'list_orderdetail', 'total', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
