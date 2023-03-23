<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"
    integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                            <ul class="d-flex align-items-center m-0">
                                <li class="infor-item">
                                    <a href="">
                                        Yêu thích<i class="fa-solid fa-heart"></i>
                                    </a>
                                </li>
                                <li class="infor-item">
                                    <a href="">
                                        Giỏ hàng<i class="fa-solid fa-cart-shopping me-1"></i>
                                    </a>
                                </li>
                                <li class="infor-item">

                                    <a href="">Đăng ký/Đăng nhập</a>

                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-bottom  container">
                    <div class="header-inner">
                        @includeIf('layouts.frontend.mod-mainmenu')
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
                            <ul class="m-0">
                                <li class="infor-item">
                                    <a href="">
                                        Yêu thích<i class="fa-solid fa-heart"></i>
                                    </a>
                                </li>
                                <li class="infor-item">
                                    <a href="">
                                        Giỏ hàng<i class="fa-solid fa-cart-shopping me-1"></i>
                                    </a>
                                </li>
                                <li>
                                    <p class="infor-item">
                                        <a href="">Đăng ký/Đăng nhập</a>
                                    </p>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-bottom  ">
                  
                    <div class="header-inner">
                        @includeIf('layouts.frontend.mod-mainmenu')
                    </div>
                </div>
            </div>
        </div>
    </header>





@yield('content')






    <script>
        var navbar = document.getElementById("navbar");
        var menuWrapper = document.getElementById("menu-wrapper");
        var lastScrollTop = 0;
        window.onscroll = function() {
            var currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (currentScrollTop > lastScrollTop) {
                // Cuộn xuống
                if (currentScrollTop >= navbar.offsetTop + navbar.offsetHeight) {
                    menuWrapper.classList.add("sticky");
                }
            } else {
                // Cuộn lên
                menuWrapper.classList.remove("sticky");
            }
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
    integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('footer')

</body>

</html>
