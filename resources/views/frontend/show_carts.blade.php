@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buy_amount.css') }}">
@endsection
@section('footer')
    <script src="{{ asset('js/amountcart.js') }}"></script>
@endsection
@section('content')
    <div class="container myaccount">
        <div class="row">
            <div class="checkout-breadcrumbs text-center">
                <a style="color: #46423E!important" class="fs-5 d-inline">GIỎ HÀNG CỦA TÔI > </a>
                <a href="{{ route('site.checkout') }}" class="fs-5">CHI TIẾT THANH TOÁN > </a>

                <a style=" color:  #BCB6B2 !important    " class="fs-5 d-inline">HOÀN THÀNH ĐẶT HÀNG</a>
            </div>
            <div class="col-md-8 right-content">

                <div class="p-3 border-end">

                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th  style="width: 5%" scope="col"></th>
                                <th style="width: 15%" scope="col"></th>
                                <th  class="text-center" style="width: 40%" scope="col">Sản phẩm</th>
                                <th class="text-center" style="width: 20%" scope="col">Giá</th>
                                <th class="text-center" style="width: 20%" scope="col">SL</th>
                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($carts as $cart)
                                <tr class="form-qty">
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
                                    <th class="align-middle" scope="row"><i id=""
                                            class="fa-solid fa-circle-xmark delete-cart-item"></i>
                                    </th>
                                    <td class="align-middle"><img class="img-fluid" src="{{ asset('images/product/'.$cart->product->images[0]->image) }}"></td>
                                    <td class="align-middle"><a href="{{ route('slug.index',['slug'=>$cart->product->slug]) }}" class="fw-200">{{ $cart->product->name }}</a>
                                    </td>
                                    <td class=" align-middle"><span
                                            style="color:#FFAD03 ;">{{ number_format($product_price) }} VNĐ</span></td>
                                    <td class=" align-middle">
                                        @if ($cart->product->qty >0)
                                        <div class="ms-4 buy-amount">
                                            <input type="hidden" value="{{ $cart->product->qty }} " class="qty_max">
                                            <input type="hidden" value="{{ $cart->product_id }} " class="product_id">

                                            <button class="minus-btn changeqty">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                                </svg>
                                            </button>
                                            <input type="text" class="amount" name="amount" value="{{ $cart->qty }}">
                                            <button class="plus-btn changeqty">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                            </button>
                                        </div>
                                        @else
                                        <div class="ms-4 text-danger text-center">
                                            Hết hàng
                                        </div>
                                        @endif
                                        
                                    </td>
                                   
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-4 ">
                <div class="p-3">
                    <div style="border-bottom: 2.5px solid #dee2e6 " class="row">
                        <h6 class=" pb-2  ">CỘNG GIỎ HÀNG</h6>

                    </div>
                    <div class="row  border-bottom py-2">

                        <div class="col-4">Tạm tính</div>
                        <div class="col-8 text-end  fw-bold">{{ number_format($total) }} VND</div>
                    </div>
                    <div class="row  border-bottom py-2">

                        <div class="col-4 align-middle ">Giao hàng</div>
                        <div class="col-8">
                            <div class="row text-end">
                                
                                <p>Đồng giá: <span class="fw-semibold">0 VND</span> </p>
                        
                                <p style="font-size: 73%; color:#37800d ">chọn tiến hành thanh toán để đổi địa chỉ</p>
                            </div>
                        </div>
                    </div>
                    <div style="border-bottom: 2.5px solid #dee2e6 " class="row   py-2">

                        <div class="col-4">Tổng</div>
                        <div class="col-8 text-end fw-bold">{{ number_format($total) }} VND
                        </div>
                    </div>
                </div>
                <div class="text-center"> <a href="{{ route('site.checkout') }}" style="width: 100%"
                        class="btn btn-danger ">Tiến hành thanh toán</a>
                </div>


            </div>

        </div>
    </div>
    </div>


@endsection
