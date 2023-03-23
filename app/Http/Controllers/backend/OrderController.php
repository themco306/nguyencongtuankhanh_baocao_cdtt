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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::join('user', 'user.id', '=', 'order.user_id')
            ->where('order.id', '=', $id)
            ->first();
        if ($order == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $list_orderdetail = Product::join('Orderdetail', 'product.id', '=', 'orderdetail.product_id')
            ->select('*', 'product.price as product_price', 'product.qty as product_qty')
            ->where('orderdetail.order_id', '=', $id)
            ->get();

        $title = 'Chi Tiết Đơn Hàng';
        $tongtien = 0;
        return view("backend.order.show", compact('title', 'order', 'list_orderdetail', 'order', 'tongtien'));
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
