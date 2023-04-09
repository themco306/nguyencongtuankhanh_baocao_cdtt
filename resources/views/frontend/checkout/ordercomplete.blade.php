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
                <a  href="{{ route('site.checkout') }}" class="fs-5">CHI TIẾT THANH TOÁN >
                </a>

                <a style=" color:  #46423E !important    " class="fs-5 d-inline">HOÀN THÀNH ĐẶT HÀNG</a>
            </div>
        </div>
    </div>


@endsection
