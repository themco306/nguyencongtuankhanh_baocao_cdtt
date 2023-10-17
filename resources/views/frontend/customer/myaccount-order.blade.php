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
                <a   href="{{ route('site.myaccount') }}">trang tài khoản</a>
            </li>
            <li>
                <a  style="color:#333" href="{{ route('account.order') }}">đơn hàng <i class="fa-solid fa-hand-point-right fa-beat" ></i></a>
            </li>
            <li>
                <a href="{{ route('account.address') }}">địa chỉ</a>
            </li>
            <li>
                <a href="{{ route('account.edit') }}">tài khoản</a>
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
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th style="width: 15%;" scope="col">Đơn hàng</th>
                    <th style="width: 15%;" scope="col">Ngày</th>
                    <th style="width: 25%;" scope="col">Tình trạng</th>
                    <th style="width: 35%;" scope="col">Tổng</th>
                    <th style="width: 10%;" scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order as $item)
                    <tr>
                        <td style="color:#777573" class="text-start ">#{{ $item->code }}</td>
                        <td>{{ $item->exportdate }}</td>
                        <td>
                            <a href="{{ route('site.ordercomplete',['code'=>$item->code]) }}" class='text-{{   $list_status[$item->status]['type'] }}'>
                                {{   $list_status[$item->status]['text'] }}
                            </a>
                        </td>
                        <td><span class="fw-bold">{{ number_format($item->a_total_price) }} VND</span> cho {{ $item->a_total_qty }} mục</td>
                        <td class="text-center"><a href="" class="">Xem</a></td>
                    </tr>
                @endforeach
                


            </tbody>
        </table>
         </div>



    </div>
</div>
</div>


@endsection