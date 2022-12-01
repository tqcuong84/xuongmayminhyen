@extends('master')
@section('head_js')
<script> 
function gtag_report_conversion(url) { 
  var callback = function () { 
    if (typeof(url) != 'undefined') { 
      window.location = url; 
    } 
  }; 
  gtag('event', 'conversion', { 
      'send_to': 'AW-11029924175/3w75CJG1hYMYEM-SvYsp', 
      'event_callback': callback 
  }); 
  return false; 
} 
</script>
@stop
@section('content')


    <!-- start of hero -->
    <section class="hero">
        <div class="hero-slider hero-slider-s1">
            @if($is_mobile) 
                @if($home_page_banner)
                <div class="slide-item">
                    <img src="{{ $home_page_banner->banner_file }}" alt="" class="slider-bg">
                    <div class="slide-item__info">
                        <h2>{!! $home_page_banner->name !!}</h2>
                        <p>{!! $home_page_banner->note !!}</p>
                    </div>
                </div>
                @endif
            @else
                @foreach($home_page_banner as $home_page_banner_item)
                <div class="slide-item">
                    <img src="{{ $home_page_banner_item->banner_file }}" alt="" class="slider-bg" />
                    <div class="slide-item__info">
                        <h2>{!! $home_page_banner_item->name !!}</h2>
                        <p>{!! $home_page_banner_item->note !!}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </section>
    <!-- end of hero slider -->
    @include("header")
    <h1 class="h1-homepage">{{ settings("h1-home-page") }}</h1>
    <!-- start wedding-couple-section -->
    @if($latest_product_articles)
    <section class="wedding-couple-section section-padding" id="products">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    @foreach($latest_product_articles as $latest_product_article)
                    <div class="gb">
                        @if(!($loop->index % 2 == 0))
                        <div class="img-holder wow fadeInLeftSlow">
                            <a href="{{ $latest_product_article->url_details }}"><img src="{{ $latest_product_article->avatar_file }}" alt="{{ $latest_product_article->title }}"></a>
                        </div>
                        @endif
                        <div class="details">
                            <div class="details-inner">
                                <a href="{{ $latest_product_article->url_details }}"><h3>{{ $latest_product_article->title }}</h3></a>
                                <p>{{ $latest_product_article->description }}</p>
                            </div>
                        </div>
                        @if($loop->index % 2 == 0)
                        <div class="img-holder wow fadeInRightSlow">
                            <a href="{{ $latest_product_article->url_details }}"><img src="{{ $latest_product_article->avatar_file }}" alt="{{ $latest_product_article->title }}"></a>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    @endif
    <!-- end wedding-couple-section -->


    <!-- start count-down-section -->
    <section class="count-down-section section-padding parallax" @if($article_banner) data-bg-image="{{ $article_banner->banner_file }}" data-speed="7" @endif>
        <div class="container">
            <div class="row">
                <div class="col col-md-4">
                    @if(settings('article-home-page-banner-text-visibility') == 1)
                    <h2>@if(settings('article-home-page-banner-sub-text'))<span>{{ settings('article-home-page-banner-sub-text') }}</span>@endif{{ settings('article-home-page-banner-main-text') }}</h2>
                    @endif
                </div>
                <div class="col col-md-7 col-md-offset-1">
                    <div class="count-down-clock">
                        <div id="clock">
                            <div class="box"><div>{{ settings('article-home-page-banner-number-block-1') }}</div> <span>{{ settings('article-home-page-banner-text-block-1') }}</span> </div>
                            <div class="box"><div>{{ settings('article-home-page-banner-number-block-2') }}</div> <span>{{ settings('article-home-page-banner-text-block-2') }}</span> </div>
                            <div class="box"><div>{{ settings('article-home-page-banner-number-block-3') }}</div> <span>{{ settings('article-home-page-banner-text-block-3') }}</span> </div>
                            <div class="box"><div>{{ settings('article-home-page-banner-number-block-4') }}</div> <span>{{ settings('article-home-page-banner-text-block-4') }}</span> </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end count-down-section -->

    @if($latest_articles)
    <!-- start story-section -->
    <section class="story-section section-padding" id="machining_experience">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="section-title">
                        <div class="vertical-line"><span><i class="fi flaticon-two"></i></span></div>
                        <a href="{{ route('machining-experience') }}"><h2>Kinh Nghiệm Gia Công</h2></a>
                    </div>
                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12">
                    <div class="story-timeline">
                        @foreach($latest_articles as $latest_article)
                        <div class="row">
                            @if(!($loop->index % 2 == 0))
                            <div class="col col-md-6">
                                <div class="img-holder">
                                    <a href="{{ $latest_article->url_details }}"><img src="{{ $latest_article->avatar_file }}" alt="{{ $latest_article->title }}" class="img img-responsive"></a>
                                </div>
                            </div>
                            @endif
                            <div class="col col-md-6">
                                <div class="story-text right-align-text">
                                    <a href="{{ $latest_article->url_details }}"><h3>{{ $latest_article->title }}</h3></a>
                                    <p>{{ $latest_article->description }}</p>
                                </div>
                            </div>
                            @if($loop->index % 2 == 0)
                            <div class="col col-md-6">
                                <div class="img-holder right-align-text">
                                    <a href="{{ $latest_article->url_details }}"><img src="{{ $latest_article->avatar_file }}" alt="{{ $latest_article->title }}" class="img img-responsive"></a>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end story-section -->
    @endif
    @if($product_photo_banner) 
    <!-- start cta -->
    <section class="cta section-padding parallax product-photo-banner" data-bg-image="{{ $product_photo_banner->banner_file }}" data-speed="7"></section>
    @endif
    <!-- end cta -->
    @if($product_photos)
    <!-- start inportant-people-section -->
    <section class="inportant-people-section section-padding" id="product_photos">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="section-title">
                        <div class="vertical-line"><span><i class="fi flaticon-two"></i></span></div>
                        <a href="{{ route('product-photos') }}"><h2>Hình Ảnh Sản Phẩm</h2></a>
                    </div>
                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12">
                    <div class="inportant-people-content">
                        <div class="tab-content">
                            <div class="tab-pane fade in active grid-wrapper" id="groomsmen">
                                @foreach($product_photos as $product_photo)
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ $product_photo->avatar_file }}" class="popup-image">
                                            <img src="{{ $product_photo->avatar_file }}" alt="{{ $product_photo->title }}" class="img img-responsive">
                                        </a>
                                    </div>
                                    <div class="details">
                                        <a href="{{ $product_photo->url_details }}"><h3>{{ $product_photo->title }}</h3></a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end inportant-people-section -->
    @endif

    @if($galleries)
    <!-- start gallery-section -->
    <section class="gallery-section section-padding" id="gallery">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="section-title">
                        <div class="vertical-line"><span><i class="fi flaticon-two"></i></span></div>
                        <a href="{{ route('galleries') }}"><h2>Hình Ảnh Xưởng May</h2></a>
                    </div>
                </div>
            </div> <!-- end section-title -->

            <div class="row">
                <div class="col col-xs-12 sortable-gallery">
                    <div class="gallery-container gallery-fancybox masonry-gallery">
                        @foreach($galleries as $gallery)
                        <div class="grid">
                            <a href="{{ $gallery->avatar_file }}" class="fancybox" data-fancybox-group="gall-1">
                                <img src="{{ $gallery->avatar_file }}" alt="{{ $gallery->title }}" class="img img-responsive">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end gallery-section -->
    @endif



    <!-- start rsvp-section -->
    <section id="contact-us-section" class="rsvp-section section-padding parallax" @if($contact_banner) data-bg-image="{{ $contact_banner->banner_file }}" data-speed="7" @endif id="contact">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="section-title-white">
                        <div class="vertical-line"><span><i class="fi flaticon-two"></i></span></div>
                        <h2>Liên hệ với chúng tôi</h2>
                    </div>
                </div>
            </div> <!-- end section-title -->

            <div class="row content">
                <div class="col col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <p>Quý khách vui lòng nhập các thông tin sau:</p>
                    <form id="rsvp-form" class="form validate-rsvp-form row" method="post">
                        <div class="col col-sm-6">
                            <input type="text" name="name" class="form-control" placeholder="Tên của quý khách*">
                        </div>
                        <div class="col col-sm-6">
                            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại*">
                        </div>
                        <div class="col col-sm-12">
                            <textarea class="form-control" name="content" placeholder="Nội dung liên hệ*"></textarea>
                        </div>
                        <div class="col col-sm-12 submit-btn">
                            <button type="submit" class="submit">Gửi thông tin</button>
                            <span id="loader"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></span>
                        </div>
                        <div class="col col-md-12 success-error-message">
                            <div id="success">Thông tin của quý khách đã được gửi thành công, chúng tôi sẽ liên hệ trong thời gian sớm nhất.</div>
                            <div id="error">Đã xảy ra lỗi khi gửi email. Vui lòng thử lại sau.</div>
                        </div>
                    </form>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end rsvp-section -->


    <!-- start getting-there-section -->
    <section class="getting-there-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="section-title-white">
                        <div class="vertical-line"><span><i class="fi flaticon-two"></i></span></div>
                        <h2>Xưởng May Cho Mọi Giấc Mơ</h2>
                    </div>
                </div>
            </div> <!-- end section-title -->

            <div class="row content">
                <div class="col col-md-12">
                    {!! settings("xuong-may-cho-moi-giac-mo") !!}
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end getting-there-section -->


    <!-- start gift-registration-section -->
    <section class="gift-registration-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="section-title">
                        <div class="vertical-line"><span><i class="fi flaticon-two"></i></span></div>
                        <h2>Đối Tác Của Chúng Tôi</h2>
                    </div>
                </div>
            </div> <!-- end section-title -->

            <div class="row content">
                <div class="col col-lg-10 col-lg-offset-1">
                    <div>{!! settings("doi-tac-cua-chung-toi") !!}</div>

                    <div class="gif-registration-slider">
                        @foreach($brands as $brand)
                        <div class="register">
                            <img src="{{ $brand->avatar_file }}" alt="{{ $brand->title }}" class="img img-responsive">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end gift-registration-section -->
@stop