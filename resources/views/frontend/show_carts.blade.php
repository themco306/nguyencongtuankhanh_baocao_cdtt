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
            <div class="col-md-8 right-content">
                <div class="px-3">
                    <h4 class="fs-5">giỏ hàng CỦA TÔI </span></h4>
                </div>
                <div class="p-3 border-end">

                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%" scope="col"></th>
                                <th style="width: 15%" scope="col"></th>
                                <th style="width: 45%" scope="col">Sản phẩm</th>
                                <th style="width: 20%" scope="col">Giá</th>
                                <th style="width: 10%" scope="col">SL</th>
                                <th style="width: 5%" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <x-table-cart :rowcart="$cart" />
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
                            <div class="col-8 text-end  fw-bold">648K VND</div>
                        </div>
                        <div class="row  border-bottom py-2">

                            <div class="col-4 align-middle">Giao hàng</div>
                            <div class="col-8">
                                <div class="row text-end">
                                    <p>Đồng giá: <span class="fw-semibold">35K VND</span> </p>
                                    <p>Vận chuyển đến y, Huyện Ba Bể, Bắc Kạn.</p>
                                    <p>Đổi địa ch</p>
                                </div>
                            </div>
                        </div>
                        <div style="border-bottom: 2.5px solid #dee2e6 " class="row   py-2">

                            <div class="col-4">Tổng</div>
                            <div class="col-8 text-end fw-bold">683K VND
                            </div>
                        </div>
                </div>
                <div class="text-center"> <button style="width: 100%"  class="btn btn-danger ">Tiến hành thanh toán</button></div>
                

            </div>

        </div>
    </div>
    </div>


@endsection
