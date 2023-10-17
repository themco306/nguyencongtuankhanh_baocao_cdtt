<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Orderdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ['type' => 'success', 'text' => 'Đã thanh toán'],
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
                case 'thanhtoan': {
                        $order->status = 2;
                        break;
                    }
                case 'donggoi': {
                        $order->status = 3;
                        break;
                    }
                case 'vanchuyen': {
                        $order->status = 4;
                        break;
                    }
                case 'dagiao': {
                        $order->status = 5;
                        break;
                    }
                case 'huy': {
                        $order->status = 6;
                        break;
                    }
            }
            $order->updated_at = date('Y-m-d H:i:m');
            $order->updated_by = Auth::guard('admin')->user()->id;
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

    // public function destroy($id)
    // {
    //     $order = Order::find($id);
    //     if ($order == null) {
    //         return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
    //     }
    //     if ($order->status != 6) {
    //         return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => 'Bạn cần hủy đơn hàng trước khi xóa']);
    //     }
    //     if ($order->delete()) {
    //         $order->orderdetail()->delete();
    //         return redirect()->route('order.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
    //     }
    //     return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    // }
    public function trash_multi(Request $request)
    {

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $order = Order::find($id);
                    if ($order == null) {
                        return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    $order->status = 6;
                    $order->updated_at = date('Y-m-d H:i:m');
                    $order->updated_by = Auth::guard('admin')->user()->id;
                    if ($order->save()) {

                        $count++;
                    }
                }
                return redirect()->route('order.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !"]);
            } else {
                return redirect()->route('order.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }
}
