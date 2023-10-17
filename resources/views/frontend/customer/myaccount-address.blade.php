@extends('layouts.frontend.site')
@section('title', $title ?? 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="{{ asset('css/myaccount.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endsection
@section('footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#province').select2();
            $('#district').select2();
            $('#ward').select2();

        });
    </script>
    <script src="{{ asset('js/province.js') }}"></script>
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
                        <a style="color:#333" href="{{ route('account.address') }}">địa chỉ <i
                                class="fa-solid fa-hand-point-right fa-beat"></i></a>
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
                    <label for="show-address">Địa chỉ giao hàng</label>
                    
                    <input class="form-control" type="text" name="show-address" id="show-address" value="" readonly>
                </div>
                <div class="m-3">
                    <h4 class="fs-5 border-bottom">Sửa Địa chỉ giao hàng</h4>
                    <form action="" method="post">
                        @csrf
                        <label class="my-3" for="country">Quốc gia/Khu vực*</label>
                        <p id="country">Việt Nam</p>
                        <input type="hidden" value="{{ $user->province }}" id="get_province">
                        <label class="my-3" for="province">Tỉnh/Thành phố*</label>
                        <select class="form-control " name="province" id="province">
                            <option value="">---Tỉnh/Thành phố---</option>
                        </select>
                        
                        @if ($errors->has('province'))
                            <div class="text-danger">
                                {{ $errors->first('province') }}
                            </div>
                        @endif
                        <input type="hidden" value="{{ $user->district }}" id="get_district">
                        <label class="my-3" for="district">Quận/Huyện*</label>
                        <select class="form-control" name="district" id="district">
                            <option value="">---Quận/Huyện---</option>
                        </select>
                        @if ($errors->has('district'))
                            <div class="text-danger">
                                {{ $errors->first('district') }}
                            </div>
                        @endif
                        <input type="hidden" value="{{ $user->ward }}" id="get_ward">
                        <label class="my-3" for="ward">Phường/Xã*</label>
                        <select class=" form-control" name="ward" id="ward">
                            <option value="">---Phường/Xã---</option>
                        </select>
                        @if ($errors->has('ward'))
                            <div class="text-danger">
                                {{ $errors->first('ward') }}
                            </div>
                        @endif
                        <label class="my-3" for="address">Địa chỉ*</label>
                        <input class="form-control" type="text" name="address" id="address"
                            placeholder="Ấp Giá Trên, Đường số 2, số nhà 334,..."
                            value="{{ old('address',$user->address) }}">
                        @if ($errors->has('address'))
                            <div class="text-danger">
                                {{ $errors->first('address') }}
                            </div>
                        @endif
                        <button class="my-3 p-2" type="submit">LƯU ĐỊA CHỈ</button>
                    </form>
                </div>



            </div>
        </div>
    </div>


@endsection
