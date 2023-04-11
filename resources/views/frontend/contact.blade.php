@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('footer')

@endsection
@section('content')

<section class="body container">
    <div class="row">
        <div class="col-md-6">
            <h3>{{ $list[0] }}</h3>
            <p>
                Đối với bất kỳ những nhận xét, câu hỏi hoặc đề xuất liên quan đến tài khoản của bạn, vui lòng liên hệ
                với nhóm hỗ trợ của mohinhfigure.</p>

            <h4>{{ $list[1] }}
            </h4>
            <p>Đối với các câu hỏi chung, yêu cầu đối tác, cũng như thông tin liên quan đến phương tiện truyền thông,
                hãy
                liên hệ với Thèm Anime</p>
            <h4>{{ $list[2] }}
            </h4>
            <p>Đối với các yêu cầu bán hàng liên hệ với nhóm bán hàng của chúng tôi.</p>
        </div>
        <div class="col-md-6">
            <h3>Gửi tin nhắn cho chúng mình
            </h3>
            <p>Các bạn có thông tin cần liên hệ, hoặc cần hợp tác, các bạn có thể liên hệ qua Zalo, Facebook, Fanpage
                hoặc để lại thông tin liên hệ ở đây, chúng tôi sẽ liên hệ lại ngay</p>
            <form action="{{ route('site.postlienhe') }}" method="post">
                @csrf
                
                <label for="name">Tên của bạn</label>
                <input type="text" name="name" class="form-control">
                @if ($errors->has('name'))
                <div class="text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
                <label for="email">Địa chỉ email</label>
                <input type="email" name="email" class="form-control">
                @if ($errors->has('email'))
                <div class="text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
                <label for="phone">Số điện thoại</label>
                <input type="phone" name="phone" class="form-control">
                @if ($errors->has('phone'))
                <div class="text-danger">
                    {{ $errors->first('phone') }}
                </div>
            @endif
                <label for="title">Bạn cần gì</label>
                <select name="title" class="form-control" >
                    {!! $list_option !!} 
                </select>
                <label for="detail">Nội dung</label>
                <textarea name="detail" class="form-control" ></textarea>
                @if ($errors->has('detail'))
                <div class="text-danger">
                    {{ $errors->first('detail') }}
                </div>
            @endif
                <button type="submit" name="GUI" class="mt-1 btn btn-success">Gửi</button>
            </form>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6">
            <h4>Shop Chuyên Bán Mô Hình Figure</h4>
            <p>Đường dây nóng:{{ $config->phone  }} </p>
            <p>Email:{{ $config->email  }} </p>
            <p><a href="{{ $config->facebook }}">Facebook</a></p>
        </div>
        <div class="col-md-6">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10359.75727209878!2d106.78964216526178!3d10.882794686893838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d8905d16ff39%3A0x102ff70a71e547c8!2zQ0jDmUEgVEhJw4pOIFFVQU5H!5e0!3m2!1svi!2s!4v1673086812314!5m2!1svi!2s"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

@endsection