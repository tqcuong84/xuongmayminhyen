@extends('master')
@section('content')
  <div class="page-title" @php if($top_banner !== null && $top_banner->banner_file) { echo 'style="background: url('.$top_banner->banner_file.') center center/cover no-repeat local !important;"';  }  @endphp>
      <div class="container">
          <div class="row">
              <div class="col col-xs-12">
                  @if($page_name == 'products')
                  <h2>Sản Phẩm</h2>
                  <div class="breadcrumb">
                      <ul>
                          <li><a href="/">Trang chủ</a></li>
                          <li>Sản Phẩm</li>
                      </ul>
                  </div>
                  @else
                  <h2>Kinh Nghiệm Gia Công</h2>
                  <div class="breadcrumb">
                      <ul>
                          <li><a href="/">Trang chủ</a></li>
                          <li>Kinh Nghiệm Gia Công</li>
                      </ul>
                  </div>
                  @endif
              </div>
          </div>
      </div> <!-- end container -->
  </div> <!-- end page-title -->
  @include("header")
  <!-- start blog-main -->
  <section class="blog-main section-padding">
    <div class="container">
        <div class="row">
            <div class="blog-content col col-md-8">
              @if($articles)
                @foreach($articles as $article)
                <div class="post">
                    <div class="entry-header">
                        <div class="entry-date-media">
                            <div class="entry-media">
                                <img src="{{ $article->avatar_file }}" class="img img-responsive" alt="{{ $article->title }}">
                            </div>
                        </div>
                        <div class="entry-formet">
                            <div class="entry-meta"></div>
                        </div>

                        <div class="entry-title">
                            <h3><a href="{{ $article->url_details }}">{{ $article->title }}</a></h3>
                        </div>
                    </div> <!-- end of entry-header -->

                    <div class="entry-content">
                        <p>{{ $article->description }}</p>
                        <a href="{{ $article->url_details }}" class="read-more">Xem thêm</a>
                    </div> <!-- end of entry-content -->
                </div> <!-- end of post -->
                @endforeach
                {{ $articles->links('paginator') }}
              @endif  
            </div> <!-- end of blog-content -->

            <div class="blog-sidebar col col-md-4">
                @if($page_name == 'products' && isset($product_categories) && $product_categories)
                <div class="widget categories-widget">
                    <h3>Danh mục</h3>
                    <ul>
                        @foreach($product_categories as $product_category)
                        <li><a href="{{ $product_category->url_details }}">{{ $product_category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(count($hot_articles))
                <div class="widget popular-posts-widget">
                    <h3>
                    @if($page_name == 'products')
                    Sản Phẩm Nổi Bật
                    @else
                    Kinh Nghiệm Nổi Bật
                    @endif
                    </h3>
                    <ul>
                      @foreach($hot_articles as $article)
                        <li>
                            <div>
                                <h6><a href="{{ $article->url_details }}">{{ $article->title }}</a></h6>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div> <!-- end of sidebar -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
 </section>
<!-- end of blog-main -->
@stop