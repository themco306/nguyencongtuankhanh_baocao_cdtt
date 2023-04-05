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
                <img class="img-fluid" src="{{ asset('images/user/'.$user->image) }}" alt="{{$user->image }}">
            </div>
            <div class="col-8 name">
                <p >{{ $user->name }}</p>
            </div>
        </div>
        <ul>
            <li  >
                <a  style="color:#333" href="{{ route('site.myaccount') }}">trang tài khoản <i class="fa-solid fa-hand-point-right fa-beat" ></i></a>
            </li>
            <li>
                <a href="{{ route('account.order') }}">đơn hàng</a>
            </li>
            <li>
                <a href="{{ route('account.address') }}">địa chỉ</a>
            </li>
            <li>
                <a href="{{ route('account.edit') }}">tài khoản </a>
            </li>
            <li>
                <a href="{{ route('account.wishlist') }}">yêu thích</a>
            </li>
            <li>
                <a title="Bấm vào để đăng xuất ngay lập tức" href="{{ route('site.logout') }}">Đăng xuất</a>
            </li>
        
        </ul>
    </div>
    <div class="col-9 right-content">
       <div class="m-3">
        <p> Xin chào <span style="font-weight: bold">{{ $user->name }} </span>(không phải tài khoản  <span style="font-weight: bold">{{ $user->name }} </span>? Hãy  <a title="Bấm vào để đăng xuất ngay lập tức" href="{{ route('site.logout') }}">thoát ra</a> và đăng nhập vào tài khoản của bạn)</p>
<p>Từ trang quản lý tài khoản bạn có thể xem <a href="{{ route('account.order') }}"> đơn hàng mới</a>, quản lý <a href="{{ route('account.address') }}"> địa chỉ giao hàng và thanh toán</a>, <a href="{{ route('account.edit') }}"> sửa mật khẩu và thông tin tài khoản</a>.</p>
         </div>



    </div>
</div>
</div>


@endsection