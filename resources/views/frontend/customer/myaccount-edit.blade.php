@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
@endsection
@section('content')
    <div class="container myaccount">
        <div>
            <h4>TÀI KHOẢN CỦA TÔI</h4>
        </div>
        <div class="row">
            <div class="col-3 left-content">
                <div class="row">
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('images/user/' . $user->image) }}" alt="{{ $user->image }}">
                    </div>
                    <div class="col-8 name">
                        <p>{{ $user->name }}</p>
                    </div>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('site.myaccount') }}">trang tài khoản</a>
                    </li>
                    <li>
                        <a href="{{ route('account.order') }}">đơn hàng</a>
                    </li>
                    <li>
                        <a href="{{ route('account.address') }}">địa chỉ</a>
                    </li>
                    <li>
                        <a style="color:#333" href="{{ route('account.edit') }}">tài khoản <i class="fa-solid fa-hand-point-right fa-beat" ></i></a>
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
                    <form action="" method="post">
                        <label class="my-3" for="name">Tên hiển thị* ( <span style="font-weight: 100">tên này sẽ hiển
                                thị khi bạn đánh giá sản phẩm</span> )
                        </label>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ old('name', $user->name) }}">
                        <label class="my-3" for="email">Địa chỉ email* ( <span style="font-weight: 100">nếu thay đổi
                                địa chỉ email bạn sẽ đăng xuất và xác thực lại cho địa chỉ mới</span> )
                        </label>
                        <input class="form-control" type="text" name="email" id="email"
                            value="{{ old('email', $user->email) }}">

                        <h4 class="mt-4 mb-1 border-bottom fs-5">Thay đổi mật khẩu</h4>
                        <label class="my-3" for="password">Mật khẩu hiện tại ( <span style="font-weight: 100">bỏ trống nếu
                                không đổi</span> )
                        </label>
                        <input class="form-control" type="password" name="password" id="password" value="">

                        <label class="my-3" for="new-password">Mật khẩu mới ( <span style="font-weight: 100">bỏ trống nếu
                                không đổi</span> )
                        </label>
                        <input class="form-control" type="password" name="new-password" id="new-password" value="">

                        <label class="my-3" for="confirm-password">Xác nhận mật khẩu mới
                        </label>
                        <input class="form-control" type="password" name="confirm-password" id="confirm-password" value="">
                        <button  class="my-3 p-2" type="submit">LƯU THAY ĐỔI</button>
                    </form>
                </div>



            </div>
        </div>
    </div>


@endsection
