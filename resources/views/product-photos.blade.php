@extends('master')
@section('content')
  <div class="page-title" @php if($top_banner !== null && $top_banner->banner_file) { echo 'style="background: url('.$top_banner->banner_file.') center center/cover no-repeat local !important;"';  }  @endphp>
      <div class="container">
          <div class="row">
              <div class="col col-xs-12">
                  <h2>Hình Ảnh Sản Phẩm</h2>
                  <div class="breadcrumb">
                      <ul>
                          <li><a href="/">Trang chủ</a></li>
                          <li>Hình Ảnh Sản Phẩm</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div> <!-- end container -->
  </div> <!-- end page-title -->
  @include("header")
  <!-- start blog-main -->
  <section class="inportant-people-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="inportant-people-content">
                        <div class="tab-content">
                            <div class="tab-pane fade in active grid-wrapper">
                                @foreach($product_photos as $product_photo)
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ $product_photo->url_details }}">
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
@stop
@section('js')
@stop