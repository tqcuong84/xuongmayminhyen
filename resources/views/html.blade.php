@extends('master')

@section('content')
  <div class="page-title" @php if($html !== null && $html['banner_file']) { echo 'style="background: url('.$html["banner_file"].') center center/cover no-repeat local !important;"';  }  @endphp>
      <div class="container">
          <div class="row">
              <div class="col col-xs-12">
                  <h1>{{ $html['title'] }}</h1>
                  <div class="breadcrumb">
                      <ul>
                          <li><a href="/">Trang chủ</a></li>
                          <li>{{ $html['title'] }}</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div> <!-- end container -->
  </div> <!-- end page-title -->
  @include("header")
  <section class="blog-main blog-details-content section-padding">
      <div class="container">
          <div class="row">
              <div class="blog-content col col-md-8">
                  <div class="post">
                      <div class="entry-content">
                        {!! $html['content'] !!}
                      </div> <!-- end of entry-content -->
                  </div>
                  
              </div> <!-- end of blog-content -->

              <div class="blog-sidebar col col-md-4">

              @if($hot_articles)
                <div class="widget popular-posts-widget">
                    <h3>Bài viết nổi bật</h3>
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
@stop