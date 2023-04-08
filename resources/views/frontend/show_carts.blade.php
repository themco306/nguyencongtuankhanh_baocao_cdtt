@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
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
                            <x-table-cart :rowcart="$cart"/>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-4 ">
                <div class="p-3">
                    <h6  class=" pb-2 border-bottom ">CỘNG GIỎ HÀNG</span></h4>
                        <div class="row">
                            <div class="col-4">Tạm tính</div>
                            <div class="col-8">648K VND</div>
                            <div class="col-4 align-middle">Giao hàng</div>
                            <div class="col-8">
                                <div class="row">
                                    <p>Đồng giá: 35K VN</p>
                                    <p>Vận chuyển đến y, Huyện Ba Bể, Bắc Kạn.</p>
                                    <p>Đổi địa ch</p>
                                </div>
                            </div>
                            <div class="col-4">Tổng</div>
                            <div class="col-8">683K VND
                            </div>
                        </div>
                        <button>Tiến hàng thanh toán</button>
                
                </div>

            </div>
        </div>
    </div>


@endsection
