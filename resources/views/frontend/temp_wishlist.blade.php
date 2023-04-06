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
<div class="row">
    <div class=" right-content">
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