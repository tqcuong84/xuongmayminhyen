<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        if(!isset($page_name)){
            $page_name = '';
        }
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($meta_title)
    <meta property="og:title" content="{{ $meta_title }}"/>
    <meta property="og:url" content="{{ $canonical_url }}"/>
    <meta property="og:image" content="{{ $meta_image }}"/>
    <meta property="og:description" content="{{$meta_description}}"/>
    <meta name="keywords" content="{{ $meta_keyword }}" />
    <meta name="description" content="{{$meta_description}}" />
    <meta property="og:site_name" content="{{ $domain_name }}"/>
    @endisset
    <meta property="og:type" content="website"/>
    <meta name="author" content="Xưởng May Minh Yến" />
    <meta name="google-site-verification" content="8l6UgjUuDpud_iq14KYlXMrzTCOGhsPQR5bVOUVzudQ" />

    <title>@isset($page_title) {{ $page_title }} @endisset</title>
    @isset($canonical_url)
    <link rel="canonical" href="{{$canonical_url}}" />
    @endisset

    <!-- Favicon and Touch Icons -->
    <link href="images/logo.png" rel="shortcut icon" type="image/png">

    <!-- Icon fonts -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flaticon.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Plugins for this template -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}?v=11" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WQ3TZHN');</script>
<!-- Google tag (gtag.js) --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3HW8V4CXZF"></script> 
<script> 
  window.dataLayer = window.dataLayer || []; 
  function gtag(){window.dataLayer.push(arguments);} 
  gtag('js', new Date()); 
 
  gtag('config', 'G-3HW8V4CXZF'); 
</script>
<!-- End Google Tag Manager -->
    @yield('head_js')
</head>
<body id="home">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WQ3TZHN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="inner">
                <span class="icon"><i class="fi flaticon-two"></i></span>
            </div>
        </div>
        <!-- end preloader -->
        <!-- start preloader -->
        <div class="data-loading">
            <div class="inner">
                <span class="icon"><i class="fi flaticon-two"></i></span>
            </div>
        </div>
        <!-- end preloader -->
        @yield('content')
        <!-- start footer -->
        <footer class="site-footer">
            <div class="back-to-top">
                <a href="#" class="back-to-top-btn"><span><i class="fi flaticon-cupid"></i></span></a>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                    <div class="row  position-relative">
                        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="footer-contact-info">
                            <div class="footer-logo mb-2">
                            <a href="/"><img class="img-fluid" src="images/logo.png" width="156" alt=""></a>
                            </div>
                            <div class="contact-address">
                            <div class="contact-item mb-3 mb-md-4">
                                <p>- Trụ sở chính: {{ settings('address') }}</p>
                            </div>
                            <div class="contact-item mb-3 mb-md-4">
                                <h4 class="mb-0 fw-normal"><a href="tel:{{ settings('phone') }}">Hotline: {{ settings('phone') }}</a></h4>
                            </div>
                            <div class="contact-item">
                                <a href="mailto:{{ settings('site-email') }}">Email: {{ settings('site-email') }}</a>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
                            <h5 class="footer-title">Sản Phẩm</h5>
                            <div class="footer-link">
                                @isset($all_product_categories)
                                <ul class="list-unstyled mb-0">
                                    @foreach($all_product_categories as $all_product_category)
                                    <li><a href="{{ $all_product_category->url_details }}">{{ $all_product_category->name }}</a></li>
                                    @endforeach
                                </ul>
                                @endisset
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 mb-4 mb-sm-0">
                            <h5 class="footer-title">Thông tin chung</h5>
                            <div class="footer-link">
                                <ul class="list-unstyled mb-0">
                                <li><a href="{{ route('about.us') }}">Giới thiệu</a></li>
                                <li><a href="{{ route('goods.warranty.policy') }}">Chính sách bảo hành hàng hóa</a></li>
                                <li><a href="{{ route('payment.policy') }}">Chính sách thanh toán</a></li>
                                <li><a href="/#contact">Liên hệ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </footer>
        <!-- end footer -->
    </div>  
    <div class="zalo-chat-widget"><a href="https://zalo.me/{{ settings('phone') }}" target="_blank" rel="nofollow"><img src="images/zalo.svg" alt="" width="50" height="50"  /></a></div>
    <!-- All JavaScript files
    ================================================== -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Plugins for this template -->
    <script src="{{ asset('js/jquery-plugin-collection.js') }}"></script>

    <!-- Custom script for this template -->
    <script src="{{ asset('js/script.js') }}?v=4"></script>  
    @yield('js')
    <a href="tel:{{ settings('phone') }}" class="suntory-alo-phone suntory-alo-green" id="suntory-alo-phoneIcon" style="left: 0px; bottom: -26px;">
        <div class="suntory-alo-ph-circle"></div>
        <div class="suntory-alo-ph-circle-fill"></div>
        <div class="suntory-alo-ph-img-circle"><i class="fa fa-phone"></i></div>
    </a>
</body>
</html>    