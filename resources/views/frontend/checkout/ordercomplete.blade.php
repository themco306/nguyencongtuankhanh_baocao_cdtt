@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">

@endsection
@section('footer')

@endsection
@section('content')
    <div class="container myaccount">
        <div class="row">
            <div class="checkout-breadcrumbs text-center">
                <a href="{{ route('site.cart') }}" class="fs-5 d-inline">GIỎ HÀNG CỦA TÔI > </a>
                <a href="{{ route('site.checkout') }}" class="fs-5">CHI TIẾT THANH TOÁN >
                </a>

                <a style=" color:  #46423E !important    " class="fs-5 d-inline">HOÀN THÀNH ĐẶT HÀNG</a>
            </div>
            <div class="col-md-7 right-content">

                <div class="p-3 ">
                    @if ($order->status == 0)
                        <div>
                            <h4 class="fs-6">Xác nhận đơn hàng</h4>
                            <p>Bạn cần vào Gmail để xác nhận rằng chính bạn đã đặt hàng</p>
                        </div>
                    @endif
                    @if ($order->status == 1)
                        <div>
                            <h4 class="fs-6">Thanh toán</h4>
                            <p>Vui lòng chọn hình thức và thanh toán để đơn hàng của bạn được đóng gói</p>
                            <form action="{{ route('site.momo_payment') }}" method="post">
                                @csrf
                                <input type="hidden" name="total_payment" value="{{ $total_payment }}">
                                <input type="hidden" name="code" value="{{ $order->code }}">
                                <button type="submit" class="btn" name="payUrl">Thanh toán Momo ATM</button>
                            </form>
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary my-1" data-bs-toggle="modal" data-bs-target="#myModal">
                                Thanh toán VNPAY
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                                <div class="modal-dialog  modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header modal-dialog-centered-->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Vui lòng chọn ngân hàng</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <form action="{{ route('site.vnpay_payment') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <h4 class="fs-6">Thẻ Nội Địa</h4>
                                                <input type="radio" id="NCB" checked  name="bank" value="NCB">
                                                <label for="NCB">Ngân hàng NCP</label><br>
                                                <input type="radio" id="EXIMBANK" name="bank" value="EXIMBANK">
                                                <label for="EXIMBANK">Ngân hàng EXIMBANK</label><br>
                                                <h4 class="fs-6">Thẻ Quốc Tế</h4>
                                                <input type="radio" id="VISA" name="bank" value="VISA">
                                                <label for="VISA">Thẻ VISA </label><br>
                                                <input type="radio" id="MasterCard" name="bank" value="MasterCard">
                                                <label for="MasterCard">Thẻ MasterCard </label><br>
                                                <input type="hidden" name="total_payment" value="{{ $total_payment }}">
                                                <input type="hidden" name="code" value="{{ $order->code }}">


                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn" name="redirect">Thanh toán </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                    @endif
                    @if ($order->status > 1)
                        <div>
                            <h4 class="fs-6">Bạn đã thanh toán</h4>
                            <p>Bây giờ bạn chỉ việc chờ đợi, nếu muốn theo giỏi đơn hàng thì hãy vào <a
                                    href="{{ route('account.order') }}">đơn hàng của bạn</a></p>

                        </div>
                    @endif
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
                                $orderdetail = $order->orderdetail;
                                $total = 0;
                            @endphp
                            @foreach ($orderdetail as $item)
                                <tr>
                                    @php
                                        $product = $item->product;
                                        
                                        $total += $item->amount;
                                    @endphp
                                    <td style="color:#777573" class="text-start ">{{ $product->name }} <span
                                            style="color:#000000" class="fw-bold"> x {{ $item->qty }}</span></td>
                                    <td class="fw-bold text-end">
                                        {{ number_format($item->qty * $item->price) }} VNĐ</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-start">Tạm tính</td>
                                <td class="fw-bold text-end">{{ number_format($total) }} VNĐ</td>
                            </tr>
                            <tr>
                                <td class="align-middle text-start">Giao hàng</td>
                                <td class="text-end">Đồng giá: <span class="fw-bold text-end"> {{ number_format(0) }}
                                        VNĐ
                                    </span></td>
                            </tr>
                            <tr>
                                <td class="text-start">Tổng</td>
                                <td class="fw-bold text-end">{{ number_format($total_payment) }} VNĐ</td>
                            </tr>


                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-5 border p-3">

                <h6 class="text-success">Cảm ơn. Đơn hàng của bạn đã được nhận</h6>
                <ul>
                    <li>Mã đơn hàng: <span class="fw-bold">{{ $order->code }}</span></li>
                    <li>Người gửi: <span class="fw-bold">{{ $order->user->name }}</span></li>
                    <li>Người nhận: <span class="fw-bold">{{ $order->deliveryname }}</span></li>
                    <li>Địa chỉ giao hàng: <span class="fw-bold">{{ $order->deliveryaddress }}</span></li>
                </ul>

            </div>
        </div>
    </div>


@endsection
