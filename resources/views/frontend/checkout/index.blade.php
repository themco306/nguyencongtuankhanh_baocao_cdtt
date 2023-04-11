@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buy_amount.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endsection
@section('footer')
    <script src="{{ asset('js/amountcart.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#province').select2();
            $('#district').select2();
            $('#ward').select2();

        });
    </script>
    <script src="{{ asset('js/province.js') }}"></script>
@endsection
@section('content')
    <div class="container myaccount">
        <form action="{{ route('site.placeorder') }}" method="post">
            @csrf
        
        <div class="row">
            <div class="checkout-breadcrumbs text-center">
                <a href="{{ route('site.cart') }}" class="fs-5 d-inline">GIỎ HÀNG CỦA TÔI > </a>
                <a style="color: #46423E!important" href="{{ route('site.checkout') }}" class="fs-5">CHI TIẾT THANH TOÁN >
                </a>

                <a style=" color:  #BCB6B2 !important    " class="fs-5 d-inline">HOÀN THÀNH ĐẶT HÀNG</a>
            </div>
            <div class="col-md-7 right-content">

                <div class="p-3 ">
                    <h4 class="fs-6"> Thông tin thanh toán</h4>
                    <div class="row">
                        <p class="text-warning m-1">Nếu bạn đặt hàng cho chính mình thì không cần phải thay đổi thông tin</p>
                        <div class="col-12 my-2">
                            <label for="name">Họ và tên( <span style="font-weight: 100">bạn nên chọn tên gọi dễ đọc để
                                    người vận chuyển gọi bạn khi cần</span> )</label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="Họ và tên"
                                value="{{ $user->name }}">
                        </div>
                        <div class="col-12 my-2">
                            <div class="row">
                                <div class="col-12 my-2">
                                    <label for="">Địa chỉ giao hàng</label>
                                    <input class="form-control" type="text" name="show-address" id="show-address"
                                        value="" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="address">Địa chỉ</label>
                                    <input class="form-control" type="text" name="address" id="address"
                                        placeholder="Ấp Giá Trên, Đường số 2, số nhà 334,..."
                                        value="{{ old('address', $user->address) }}">
                                </div>
                                <div class="col-6">
                                    <input type="hidden" value="{{ $user->province }}" id="get_province">
                                    <label class="my-3" for="province">Tỉnh/Thành phố*</label>
                                    <select class="form-control " name="province" id="province">
                                        <option value="">---Tỉnh/Thành phố---</option>
                                    </select>
                                    @if ($errors->has('province'))
                                        <div class="text-danger">
                                            {{ $errors->first('province') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <input type="hidden" value="{{ $user->district }}" id="get_district">
                                    <label class="my-3" for="district">Quận/Huyện*</label>
                                    <select class="form-control" name="district" id="district">
                                        <option value="">---Quận/Huyện---</option>
                                    </select>
                                    @if ($errors->has('district'))
                                        <div class="text-danger">
                                            {{ $errors->first('district') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <input type="hidden" value="{{ $user->ward }}" id="get_ward">
                                    <label class="my-3" for="ward">Phường/Xã*</label>
                                    <select class=" form-control" name="ward" id="ward">
                                        <option value="">---Phường/Xã---</option>
                                    </select>
                                    @if ($errors->has('ward'))
                                        <div class="text-danger">
                                            {{ $errors->first('ward') }}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="row">
                                <div class="col-6">
                                    <label for="phone">Điện thoại</label>
                                    <input class="form-control" type="number" name="phone" id="phone"
                                        value="{{ old('phone', $user->phone) }}">
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="text" name="email" id="email"
                                        value="{{ old('email', $user->email) }}">
                                    @if ($errors->has('email'))
                                        <div class="text-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-5 border p-3">
                <h4 class="fs-6"> đơn hàng của bạn</h4>
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70%;" scope="col">Sản phẩm</th>
                            <th style="width: 30%;" scope="col">Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $total = 0;
                        @endphp
                        @foreach ($carts as $cart)
                            <tr>
                                @php
                                    $product = $cart->product;
                                    $product_price = $product->price; // Định nghĩa giá trị mặc định cho biến $product_price
                                    if ($product->sale->price_sale != null) {
                                        $now = now();
                                        if ($product->sale->date_begin < $now && $now < $product->sale->date_end) {
                                            $product_price = $product->sale->price_sale;
                                        }
                                    }
                                    $total += $product_price * $cart->qty;
                                @endphp
                                <td style="color:#777573" class="text-start ">{{ $cart->product->name }} <span
                                        style="color:#000000" class="fw-bold"> x {{ $cart->qty }}</span></td>
                                <td class="fw-bold text-end">
                                    {{ number_format($cart->qty * $product_price) }} VNĐ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-start">Tạm tính</td>
                            <td class="fw-bold text-end">{{ number_format($total) }} VNĐ</td>
                        </tr>
                        <tr>
                            <td class="align-middle text-start">Giao hàng</td>
                            <td class="text-end">Đồng giá: <span class="fw-bold text-end"> {{ number_format(0) }} VNĐ
                                </span></td>
                        </tr>
                        <tr>
                            <td class="text-start">Tổng</td>
                            <td class="fw-bold text-end">{{ number_format($total ) }} VNĐ</td>
                        </tr>


                    </tbody>
                </table>
                <h4 class="text-center fs-6">Hình thức thanh toán</h4>
                <h6 class="fw-bold">Chuyển khoản ngân hàng</h6>
                <p> Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi. Vui lòng sử dụng Mã đơn hàng của bạn
                    trong phần Nội dung thanh toán. Đơn hàng sẽ đươc giao sau khi tiền đã chuyển.</p>
                <div class="text-center">
                    <button style="width: 100%" class="btn btn-success">ĐẶT HÀNG</button>
                </div>
            </div>

        </div>
    </div>
</form>
    </div>


@endsection
