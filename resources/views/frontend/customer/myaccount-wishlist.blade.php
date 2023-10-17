@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
@endsection
@section('footer')
    <script src="{{ asset('js/show_wishlist_ma.js') }}"></script>
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
                <a href="{{ route('account.order') }}">đơn hàng</a>
            </li>
            <li>
                <a href="{{ route('account.address') }}">địa chỉ</a>
            </li>
            <li>
                <a href="{{ route('account.edit') }}">tài khoản</a>
            </li>
            <li>
                <a  style="color:#333" href="{{ route('account.wishlist') }}">yêu thích <i class="fa-solid fa-hand-point-right fa-beat" ></i></a>
            </li>
            <li>
                <a title="Bấm vào để đăng xuất ngay lập tức" href="{{ route('site.logout') }}">Đăng xuất</a>
            </li>
        
        </ul>
    </div>
    <div class="col-9 right-content">
       <div class="m-3">
        <div><h4 class="fs-5">Yêu thích CỦA TÔI <span class="badge fa-bounce" id="badge"></span></h4> </div>
        <table class="table">
            <thead class="table-light">
              <tr>
                <th style="width: 5%" scope="col"></th>
                <th style="width: 15%" scope="col"></th>
                <th style="width: 50%" scope="col">Sản phẩm</th>
                <th style="width: 20%" scope="col">Giá</th>
                <th style="width: 10%"  scope="col"></th>
              </tr>
            </thead>
            <tbody id="show_wishlist" >
              
            </tbody>
          </table>
         </div>



    </div>
</div>
</div>


@endsection