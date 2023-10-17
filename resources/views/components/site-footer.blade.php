<div class="container">
    <div class="footer-cta pt-5 pb-5">
        <div class="row">
            <div class="col-xl-4 col-md-4 mb-30">
                <div class="single-cta">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="cta-text">
                        <h4>Tìm chúng tôi</h4>
                        <span><a href="{{ route('site.lienhe') }}">Địa chỉ</a></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-30">
                <div class="single-cta">
                    <i class="fas fa-phone"></i>
                    <div class="cta-text">
                        <h4>Gọi cho chúng tôi</h4>
                        <span>{{ $config_footer->phone }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-30">
                <div class="single-cta">
                    <i class="far fa-envelope-open"></i>
                    <div class="cta-text">
                        <h4>Gửi Mail cho chúng tôi</h4>
                        <span>{{ $config_footer->email }}</span>
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
                        <a href="#"><img src="{{ asset('images/logo_web2.jpg') }}"
                                class="img-fluid" alt="logo"></a>
                    </div>
                    <div class="footer-text">
                        <p>{{ $config_footer->site_name }}</p>
                    </div>
                    
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                <div class="footer-widget">
                    <div class="footer-widget-heading">
                        <h3>THÔNG TIN CẦN BIẾT</h3>
                    </div>
                    <ul>
                        <x-site-footer-menu/>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                <div class="footer-social-icon">
                    <span>Theo dõi chúng tôi</span>
                    <a href="{{  $config_footer->facebook}}"><i class="fab fa-facebook-f facebook-bg"></i></a>
                    <a href="{{  $config_footer->twitter}}"><i class="fab fa-twitter twitter-bg"></i></a>
                    <a href="{{  $config_footer->google}}"><i class="fab fa-google-plus-g google-bg"></i></a>
                    
                </div>
            </div>
        </div>
    </div>
</div>