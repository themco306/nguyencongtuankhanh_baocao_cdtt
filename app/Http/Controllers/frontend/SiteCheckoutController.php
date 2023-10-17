<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        $order->deliveryaddress = $request->input('show-address');
        $accept_token = strtoupper(Str::random(6));
        $order->accept_token = $accept_token;
        $expiresAt = now()->addHours(24);
        $order->expires_at = $expiresAt;
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
        $user = Auth::guard('users')->user();
        try {
            Mail::send(
                'emails.checkorder_send',
                compact('order', 'user'),
                function ($send_email) use ($user) {
                    $send_email->subject('ShopTK - Xác nhận đơn hàng');
                    $send_email->to($user->email, $user->name);
                }
            );
        } catch (\Exception $e) {
            // Lấy thông điệp lỗi từ đối tượng ngoại lệ
            $error_message = $e->getMessage();
            return redirect()->route('site.checkout')->with('message', ['type' => 'danger', 'msg' => $error_message]);
        }
        $carts = Carts::where('user_id', Auth::guard('users')->user()->id)->get();
        foreach ($carts as $cart) {
            $cart->delete();
        }

        return redirect()->route('site.ordercomplete', ['code' => $order->code])->with('alert', "Bây giờ bạn cần xác nhận đơn hàng trong Gmail của bạn, Gmail xác nhận có hiệu lực trong vòng 24h");
    }

    public function ordercomplete($code)
    {
        $order = Order::where([['code', $code], ['user_id', Auth::guard('users')->user()->id]])->first();
        if ($order == null) {
            return redirect()->route('site.cart')->with('status', "Không tìm thấy đơn hàng của bạn bạn nếu bạn đã đặt thì hãy vào tài khoản -> đơn hàng");
        }
        $orderdetail = $order->orderdetail;
        $total_payment = 0;
        foreach ($orderdetail as $item) {
            $total_payment += $item->amount;
        }

        return view('frontend.checkout.ordercomplete', compact('order', 'total_payment'));
    }
    public function orderaccept($id, $accept_token)
    {
        $order = Order::where('id', $id)->first();
        if ($order->accept_token === $accept_token) {
            if ($order->expires_at < now()) {
                return redirect()->route('site.ordercomplete')->with('message', ['type' => 'danger', 'msg' => 'Mã xác nhận đã hết hạn!! Vui lòng đặt hàng lại!!']);
            }
            $order->status = 1;
            $order->accept_token = null;
            $order->expires_at = null;
            $order->updated_by = Auth::guard('users')->user()->id;
            $order->updated_at = date('Y-m-d H:i:s');
            $order->save();
            return redirect()->route('site.ordercomplete')->with('message', ['type' => 'success', 'msg' => 'Xác nhận đơn hàng thành công !! Vui lòng thanh toán để đơn hàng của bạn được đóng gói và gửi đi!!']);
        } else {
            return redirect()->route('site.ordercomplete')->with('message', ['type' => 'danger', 'msg' => 'Mã xác nhận đã bị chỉnh sửa !!Vui lòng vào Gmail để nhấn xác nhận lại!!']);
        }
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momo_payment(Request $request)
    {


        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $request->total_payment;
        $orderId = time() . "";
        $redirectUrl = "http://localhost:81/nguyencongtuankhanh_2121110351_lavarel/public/thanh-toan-thanh-cong/" . $request->code;
        $ipnUrl = "http://localhost:81/nguyencongtuankhanh_2121110351_lavarel/public/thanh-toan-thanh-cong/" . $request->code;
        $extraData = "";


        // $orderId = $request->code;

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        // dd($result);
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);
        // header('Location: ' . $jsonResult['payUrl']);
    }
    public function vnpay_payment(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:81/nguyencongtuankhanh_2121110351_lavarel/public/thanh-toan-thanh-cong/" . $request->code;
        $vnp_TmnCode = "ELMJXZQ8"; //Mã website tại VNPAY 
        $vnp_HashSecret = "CHVFUETMPQLBBEWGKYRSMKPADMJKVXPD"; //Chuỗi bí mật

        $vnp_TxnRef = $request->code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán VNPay';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->total_payment * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->bank ?? "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address = $_POST['txt_inv_addr1'];
        // $vnp_Bill_City = $_POST['txt_bill_city'];
        // $vnp_Bill_Country = $_POST['txt_bill_country'];
        // $vnp_Bill_State = $_POST['txt_bill_state'];
        // // Invoice
        // $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
        // $vnp_Inv_Email = $_POST['txt_inv_email'];
        // $vnp_Inv_Customer = $_POST['txt_inv_customer'];
        // $vnp_Inv_Address = $_POST['txt_inv_addr1'];
        // $vnp_Inv_Company = $_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type = $_POST['cbo_inv_type'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
            // "vnp_ExpireDate" => $vnp_ExpireDate,
            // "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            // "vnp_Bill_Email" => $vnp_Bill_Email,
            // "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            // "vnp_Bill_LastName" => $vnp_Bill_LastName,
            // "vnp_Bill_Address" => $vnp_Bill_Address,
            // "vnp_Bill_City" => $vnp_Bill_City,
            // "vnp_Bill_Country" => $vnp_Bill_Country,
            // "vnp_Inv_Phone" => $vnp_Inv_Phone,
            // "vnp_Inv_Email" => $vnp_Inv_Email,
            // "vnp_Inv_Customer" => $vnp_Inv_Customer,
            // "vnp_Inv_Address" => $vnp_Inv_Address,
            // "vnp_Inv_Company" => $vnp_Inv_Company,
            // "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            // "vnp_Inv_Type" => $vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            return redirect()->to($vnp_Url);
            // header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }
    public function success_payment($code)
    {
        $order = Order::where([['code', $code], ['user_id', Auth::guard('users')->user()->id]])->first();
        if ($order == null) {
            return redirect()->route('site.cart')->with('status', "Không tìm thấy đơn hàng của bạn bạn nếu bạn đã đặt thì hãy vào tài khoản -> đơn hàng");
        }
        $order->status = 2;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->updated_by = Auth::guard('users')->user()->id;
        $order->save();
        return redirect()->route('site.ordercomplete', ['code' => $code])->with('alert', 'Thanh toán thành công');
    }
}
