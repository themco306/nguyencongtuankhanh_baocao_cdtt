@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
@endsection
@section('footer')
<script src="{{ asset('js/check_submit.js') }}"></script>
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
                        <a style="color:#333" href="{{ route('account.edit') }}">tài khoản <i
                                class="fa-solid fa-hand-point-right fa-beat"></i></a>
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
                    <form action="" method="post" enctype="multipart/form-data" id="check_submit">
                        @csrf
                        <div class="row">
                            <div class="col-md-6"> 
                                <label class="my-3" for="name">Tên hiển thị* ( <span
                                        style="font-weight: 100">tên này sẽ hiển
                                        thị khi bạn đánh giá sản phẩm</span> )
                                </label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ old('name', $user->name) }}">
                                @if ($errors->has('name'))
                                    <div class="text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                                <label class="my-3" for="email">Địa chỉ email* ( <span style="font-weight: 100">nếu
                                        thay đổi
                                        địa chỉ email bạn sẽ đăng xuất và xác thực lại cho địa chỉ mới</span> )
                                </label>
                                <input class="form-control" type="text" name="email" id="email"
                                    value="{{ old('email', $user->email) }}">
                                    @if ($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                          
                            <div class="col-md-6">
                                <label class="my-3" for="phone">Điện thoại* ( <span style="font-weight: 100">người vận
                                        chuyển sẽ gọi cho bạn bằng số này</span> )
                                </label>
                                <input class="form-control" type="number" name="phone" id="phone"
                                    value="{{ old('phone', $user->phone) }}">
                                @if ($errors->has('phone'))
                                    <div class="text-danger">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                                <div class="">
                                    <label>Giới tính</label><br>
                                    <input type="radio" name="gender" id="nam" value="0"
                                        {{ old('gender', $user->gender) == 0 ? 'checked' : ' ' }}><label
                                        for="nam">Nam</label>
                                    <input type="radio" name="gender" id="nu" value="1"
                                        {{ old('gender', $user->gender) == 1 ? 'checked' : ' ' }}><label for="nu">Nữ</label>

                                </div>
                                <div class="">
                                    <label for="image">Hình đại diện</label>
                                    <input type="checkbox" name="def_image" value="1"
                                        {{ old('def_image') == 1 ? 'checked' : '' }}>(Mặc định)
                                    <input name="image" id="image" type="file" class="form-control "
                                        value="{{ old('image', $user->image) }}">
                                    @if ($errors->has('image'))
                                        <div class="text-danger">
                                            {{ $errors->first('image') }}
                                        </div>
                                    @endif

                                </div>


                            </div>

                        </div>


                        <h4 class="mt-4 mb-1 border-bottom fs-5">Thay đổi mật khẩu</h4>
                        <label class="my-3" for="password">Mật khẩu hiện tại ( <span style="font-weight: 100">bỏ trống nếu
                                không đổi</span> )
                        </label>
                        <input class="form-control" type="password" name="password" id="password" value="">
                        @if ($errors->has('password'))
                            <div class="text-danger">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <label class="my-3" for="new_password">Mật khẩu mới ( <span style="font-weight: 100">bỏ trống nếu
                                không đổi</span> )
                        </label>
                        <input class="form-control" type="password" name="new_password" id="new_password-password"
                            value="">
                        @if ($errors->has('new_password'))
                            <div class="text-danger">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                        <label class="my-3" for="confirm_password">Xác nhận mật khẩu mới
                        </label>
                        <input class="form-control" type="password" name="confirm_password" id="confirm_password"
                            value="">
                        @if ($errors->has('confirm_password'))
                            <div class="text-danger">
                                {{ $errors->first('confirm_password') }}
                            </div>
                        @endif
                        <button class="my-3 p-2" type="submit">LƯU THAY ĐỔI</button>
                    </form>
                </div>



            </div>
        </div>
    </div>


@endsection
