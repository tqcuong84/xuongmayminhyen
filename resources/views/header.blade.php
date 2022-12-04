<header id="header" class="site-header header-style-1">
    <nav class="navigation navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="open-btn">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="couple-logo">
                    <a href="/"><img src="/images/logo-bg.png" alt="Xưởng May Minh Yến" /></a>
                </div>
            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right navigation-holder">
                <button class="close-navbar"><i class="fa fa-close"></i></button>
                <ul class="nav navbar-nav">
                    <li><a href="/">Trang chủ</a></li>
                    <li><a href="{{ route('products') }}">Sản phẩm Gia Công</a></li>
                    <li><a href="javascript: void(0)" id="lnk-contactus">Báo Giá</a></li>
                    <li><a href="{{ route('machining-experience') }}">Kinh Nghiệm Gia Công</a></li>
                    <li class="navbar-nav__phone"><a href="tel:{{ settings('phone') }}"><img src="/images/Circle-icons-phone.png" alt="" /></a></li>
                </ul>
            </div><!-- end of nav-collapse -->
        </div><!-- end of container -->
    </nav>
</header>