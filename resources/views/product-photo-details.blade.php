@extends('master')
@section('content')
  <div class="page-title" @php if($top_banner !== null && $top_banner->banner_file) { echo 'style="background: url('.$top_banner->banner_file.') center center/cover no-repeat local !important;"';  }  @endphp>
      <div class="container">
          <div class="row">
              <div class="col col-xs-12">
                  <h1>{{ $article->title }}</h1>
                  <div class="breadcrumb">
                      <ul>
                          <li><a href="/">Trang chủ</a></li>
                          <li><a href="{{ route('product-photos') }}">Hình Ảnh Sản Phẩm</a></li>
                          <li>{{ $article->title }}</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div> <!-- end container -->
  </div> <!-- end page-title -->
  @include("header")
  <!-- start blog-main -->
  <section class="gallery-section section-padding" id="gallery">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12 sortable-gallery">
                <div class="gallery-container gallery-fancybox masonry-gallery">
                    @foreach($photos as $photo)
                    <div class="grid" id="gallery-{{ $photo['index'] }}">
                        <a href="{{ $photo['url'] }}" class="fancybox" data-fancybox-group="gall-1">
                            <img src="{{ $photo['url'] }}" alt="" class="img img-responsive" />
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
@stop
@section('js')
<script type="text/javascript">
$(document).ready(function(){
    let elm_loading = $(".data-loading");
    let timeout_load_more = null;
    let loading = false;
    let page = 1;
    let total_page = {{ $total_page }};
    window.onscroll = function() {
        var elementTarget = document.querySelector(".site-footer");
        var sbHeight = window.innerHeight * (window.innerHeight / document.body.offsetHeight);
        if ((window.scrollY + sbHeight) > (elementTarget.offsetTop - 130) && page < total_page && loading === false) {
            loadMore();
        }
    }
    function loadMore(){
        if(timeout_load_more !== null){
            clearTimeout(timeout_load_more);
        }
        page = page + 1;
        elm_loading.show();
        timeout_load_more = setTimeout(function(){
            $.ajax({
                url: window.location,
                type: "GET",
                data: {
                    page
                },
                timeout: 10000,
                beforeSend: function() {
                    loading = true;
                },
                success: function(response) {
                    loading = false;
                    elm_loading.hide();
                    if(response.photos !== undefined && response.photos !== null && response.photos.data !== undefined){
                        let _html = "";
                        let has_change = false;
                        response.photos.data.forEach((item) => {
                            if($("#gallery-" + item.index).length == 0){
                                _html += '<div class="grid" id="gallery-'+item.index+'">' + 
                                    '<a href="'+item.url+'" class="fancybox" data-fancybox-group="gall-1">' + 
                                    '<img src="'+item.url+'" alt="" class="img img-responsive" />' + 
                                    '</a></div>';
                                has_change = true;
                            }
                        });
                        if(has_change === true){
                            $(".gallery-container").append(_html);

                            setTimeout(() => {
                                if ($(".gallery-fancybox").length) {
                                    $(".fancybox").fancybox({
                                        openEffect  : "elastic",
                                        closeEffect : "elastic",
                                        wrapCSS     : "project-fancybox-title-style"
                                    });
                                }
                                var $container = $('.gallery-container');
                                $container.isotope({
                                    filter:'*',
                                    animationOptions: {
                                        duration: 750,
                                        easing: 'linear',
                                        queue: false,
                                    }
                                });
                                if ($('.masonry-gallery').length) {
                                    var $grid =  $('.masonry-gallery').masonry({
                                        itemSelector: '.grid',
                                        columnWidth: '.grid',
                                        percentPosition: true
                                    });
                                    $grid.imagesLoaded().progress( function() {
                                        $grid.masonry('layout');
                                    });
                                }
                            }, 1000);
                        }
                    }
                },
                error: function(t) {
                }
            });
        }, 500);
    }
});
</script>  
@stop