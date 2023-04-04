@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
@endsection
@section('content')
<div class="container myaccount">
    <div><h4>TÀI KHOẢN CỦA TÔI</h4></div>
<div class="row">
    <div class="col-3 left-content">
        <div class="row">
            <div class="col-4">
                <img class="img-fluid" src="{{ asset('images/user/'.Auth::guard('users')->user()->image) }}" alt="{{ Auth::guard('users')->user()->image }}">
            </div>
            <div class="col-8 name">
                <p >{{ Auth::guard('users')->user()->name }}</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="">trang tài khoản</a>
            </li>
            <li>
                <a href="">đơn hàng</a>
            </li>
            <li>
                <a href="">địa chỉ</a>
            </li>
            <li>
                <a href="">tài khoản</a>
            </li>
            <li>
                <a href="">yêu thích</a>
            </li>
            <li>
                <a title="Bấm vào để đăng xuất ngay lập tức" href="{{ route('site.logout') }}">Đăng xuất</a>
            </li>
        
        </ul>
    </div>
    <div class="col-9">

    </div>
</div>
</div>


@endsection