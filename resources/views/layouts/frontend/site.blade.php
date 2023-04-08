<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"
        integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Google Font: Source Sans Pro -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">


    @yield('header')
</head>


<body>
    <header>

        <div class="header-wrapper   ">
            <div class="header-top row text-center ">
                <div class="col-md-4 col-12 ">ĐAM MÊ KHÔNG CHỈ Ở TRÊN MÀN ẢNH</div>
                <div class="col-md-4 d-md-block d-none">
                    <ul>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <a href="">nctk@gmail.com</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <a href="">0366281394</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 d-md-block d-none float-none">SHOP MÔ HÌNH ANIME</div>
            </div>

            <div class="navbar  " id="navbar">
                <div class="header-main  d-md-block d-none container ">
                    <div class="header-inner  d-flex  justify-content-between align-items-center">
                        <div class="logo mr-5">
                            <img src="{{ asset('images/logo_web2.jpg') }}" alt="logo_web.jpg">
                        </div>
                        <div class="search align-self-center mr-3 ">
                            <form class="search-form">
                                <input type="text" placeholder="Tìm kiếm.......">
                                <input type="submit" value="Tìm">
                            </form>
                        </div>
                        <div class="infor d-md-none d-block  p-2">
                            <a href="">
                              <i class="fa-solid fa-cart-shopping me-1"></i>
                            </a>
                        </div>
                        <div class="infor align-self-center">
                            <ul class="d-flex align-items-center m-0 heart-far">
                            @if (Auth::guard('users')->check())
                                <li class="infor-item heart-icon-box heart-far">
                                    <a href="{{ route('account.wishlist') }}">
                                        Yêu thích<i class="fa-solid fa-heart fs-2">

                                        </i>
                                        <span class="badge fa-bounce" id="badge"></span>
                                    </a>
                                    <ul class="heart-sub">
                                        <li class="text-end text-decoration-underline fw-light">
                                            <a href="{{ route('account.wishlist') }}">Xem Yêu Thích</a>
                                        </li>
                                        <li>
                                            <div id="row_wishlist">

                                            </div>
                                        </li>

                                    </ul>
                                </li>
                                <li class="infor-item heart-far">
                                    <a href="{{ route('site.cart') }}">
                                        
                                        Giỏ hàng<i class="fa-solid fa-cart-shopping fs-3 me-1">
                                        </i>
                                    </a>

                                </li>
                                <li class="infor-item heart-far">
                                 <a href="{{ route('site.myaccount') }}">Tài khoản<i class="fa-solid fa-user fs-3"></i></a>
                                 @php
                                 $user_ls=Auth::guard('users')->user()->id;
                             @endphp
                                 <input type="hidden" id="get_user_ls" value="{{ $user_ls }}">
                                </li>
                                
                                 
                                @else
                                <li class="infor-item heart-icon-box heart-far">
                                    <a href="{{ route('temp.wishlist') }}">
                                        Yêu thích<i class="fa-solid fa-heart fs-2">

                                        </i>
                                        <span class="badge fa-bounce" id="badge"></span>
                                    </a>
                                    <ul class="heart-sub">
                                        <li class="text-end text-decoration-underline fw-light">
                                            <a href="{{ route('temp.wishlist') }}">Xem Yêu Thích</a>
                                        </li>
                                        <li>
                                            <div id="row_wishlist">

                                            </div>
                                        </li>

                                    </ul>
                                </li>
                                <li class="infor-item heart-far">
                                    <a href="{{ route('site.cart') }}">
                                        Giỏ hàng<i class="fa-solid fa-cart-shopping fs-3 me-1">
                                        </i>
                                    </a>

                                </li>
                                <li class="infor-item heart-far">
                                <a href="" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Đăng nhập/Đăng ký
                                </a>
                                <input type="hidden" id="get_user_ls" value="_temporary">
                                <div class="modal fade" id="myModal">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                @includeIf('frontend.modal-login')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                                @endif
                                

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-bottom  container">
                    <div class="header-inner">
                        <x-main-menu />
                    </div>
                </div>
            </div>
            <div class="menu-wrapper" id="menu-wrapper">
                <div class="header-main  d-md-block d-none">
                    <div class="header-inner d-flex  justify-content-between align-items-center">
                        <div class="logo ">
                            <img src="{{ asset('images/logo_web2.jpg') }}" alt="logo_web.jpg">
                        </div>
                        <div class="search align-self-center ">
                            <form class="search-form">
                                <input type="text" placeholder="Tìm kiếm.......">
                                <input type="submit" value="Submit">
                            </form>
                        </div>
                        <div class="infor d-md-none d-block  p-2">
                            <a href="">
                                <i class="fa-solid fa-cart-shopping me-1"></i>
                            </a>
                        </div>
                        <div class="infor align-self-center">
                            <ul class="m-0 d-flex align-items-center heart-far">
                                @if (Auth::guard('users')->check())
                                <li class="infor-item heart-icon-box heart-far">
                                    <a href="{{ route('account.wishlist') }}">
                                        Yêu thích<i class="fa-solid fa-heart fs-2">

                                        </i>
                                        <span class="badge fa-bounce" id="badge"></span>
                                    </a>
                                    <ul class="heart-sub">
                                        <li class="text-end text-decoration-underline fw-light">
                                            <a href="{{ route('account.wishlist') }}">Xem Yêu Thích</a>
                                        </li>
                                        <li>
                                            <div id="row_wishlist">

                                            </div>
                                        </li>

                                    </ul>
                                </li>
                                <li class="infor-item heart-far">
                                    <a href="">
                                        {{-- {{ route('site.cart') }} --}}
                                        Giỏ hàng<i class="fa-solid fa-cart-shopping fs-3 me-1">
                                        </i>
                                    </a>

                                </li>
                                <li class="infor-item heart-far">
                                 <a href="{{ route('site.myaccount') }}">Tài khoản<i class="fa-solid fa-user fs-3"></i></a>
                                 @php
                                 $user_ls=Auth::guard('users')->user()->id;
                             @endphp
                             <input type="hidden" id="get_user_ls" value="{{ $user_ls }}">
                                </li>
                                
                                @else
                                <li class="infor-item heart-icon-box heart-far">
                                    <a href="{{ route('temp.wishlist') }}">
                                        Yêu thích<i class="fa-solid fa-heart fs-2">

                                        </i>
                                        <span class="badge fa-bounce" id="badge"></span>
                                    </a>
                                    <ul class="heart-sub">
                                        <li class="text-end text-decoration-underline fw-light">
                                            <a href="{{ route('temp.wishlist') }}">Xem Yêu Thích</a>
                                        </li>
                                        <li>
                                            <div id="row_wishlist">

                                            </div>
                                        </li>

                                    </ul>
                                </li>
                                <li class="infor-item heart-far">
                                    <a href="{{ route('site.cart') }}">
                                        Giỏ hàng<i class="fa-solid fa-cart-shopping fs-3 me-1">
                                        </i>
                                    </a>

                                </li>
                                <li class="infor-item heart-far">
                                <a href="" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Đăng nhập/Đăng ký
                                </a>
                                <input type="hidden" id="get_user_ls" value="_temporary">
                                <div class="modal fade" id="myModal">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                @includeIf('frontend.modal-login')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-bottom  ">

                    <div class="header-inner">
                        <x-main-menu />
                    </div>
                </div>
            </div>
        </div>
    </header>




    @includeIf('backend.message_alert')
    @yield('content')

    <footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta-text">
                                <h4>Find us</h4>
                                <span>1010 Avenue, sw 54321, chandigarh</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-phone"></i>
                            <div class="cta-text">
                                <h4>Call us</h4>
                                <span>9876543210 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="far fa-envelope-open"></i>
                            <div class="cta-text">
                                <h4>Mail us</h4>
                                <span>mail@info.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="index.html"><img src="https://i.ibb.co/QDy827D/ak-logo.png"
                                        class="img-fluid" alt="logo"></a>
                            </div>
                            <div class="footer-text">
                                <p>Lorem ipsum dolor sit amet, consec tetur adipisicing elit, sed do eiusmod tempor
                                    incididuntut consec tetur adipisicing
                                    elit,Lorem ipsum dolor sit amet.</p>
                            </div>
                            <div class="footer-social-icon">
                                <span>Follow us</span>
                                <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                                <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                                <a href="#"><i class="fab fa-google-plus-g google-bg"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Useful Links</h3>
                            </div>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">about</a></li>
                                <li><a href="#">services</a></li>
                                <li><a href="#">portfolio</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Our Services</a></li>
                                <li><a href="#">Expert Team</a></li>
                                <li><a href="#">Contact us</a></li>
                                <li><a href="#">Latest News</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Subscribe</h3>
                            </div>
                            <div class="footer-text mb-25">
                                <p>Don’t miss to subscribe to our new feeds, kindly fill the form below.</p>
                            </div>
                            <div class="subscribe-form">
                                <form action="#">
                                    <input type="text" placeholder="Email Address">
                                    <button><i class="fab fa-telegram-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>




    <script>
        var navbar = document.getElementById("navbar");
        var menuWrapper = document.getElementById("menu-wrapper");
        var lastScrollTop = 0;
        window.onscroll = function() {
            var currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (currentScrollTop > lastScrollTop) {
                // Cuộn xuống
                if (currentScrollTop >= navbar.offsetTop + navbar.offsetHeight + 100) {
                    menuWrapper.classList.add("sticky");
                }
            } else {
                // Cuộn lên
                menuWrapper.classList.remove("sticky");
            }
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
        integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/site.js') }}"></script>
    @yield('footer')
</body>

</html>
