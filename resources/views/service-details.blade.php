@extends('master')

@section('content')
    <!--=================================
    Inner Header -->
    <section class="inner-header bg-holder bg-overlay-black-90" @php if($service->main_banner_file) { echo 'style="background-image: url('.$service->main_banner_file.'); background-position: center; background-size: cover;"';  }  @endphp>
      <div class="container">
        <div class="row align-items-center mb-5 pb-sm-5 pb-0 position-relative">
          <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
            <h1 class="breadcrumb-title mb-0 text-white">{{ $service->name }}</h1>
          </div>
          <div class="col-md-6">
            <ol class="breadcrumb d-flex justify-content-center justify-content-md-end ms-auto">
              <li class="breadcrumb-item"><a href="/"><i class="fas fa-home me-1"></i>Trang chủ</a></li>
              @if($service_category !== null)
              <li class="breadcrumb-item"><a href="{{ $service_category->service_url }}">{{ $service_category->name }}</a></li>
              @endif
              <li class="breadcrumb-item active"><span>{{ $service->name }}</span></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!--=================================
    Inner Header -->
    <section class="space-ptb">
      <div class="container">
        <div class="row">
          <div class="col-md-7 col-xl-8">
            <div class="blog-post blog-details">
              @if($service->avatar_file)
              <div class="blog-post-image">
                <img class="img-fluid img-avatar" src="{{ $service->avatar_file }}" alt="{{ $service->name }}">
              </div>
              @endif
              <div class="blog-post-content">
                <div class="blog-post-details">
                {!! $service->content !!}
                </div>
              </div>
              @isset($all_services)
                <div class="mt-4 mt-sm-5">
                  <h4 class="my-4">Dịch vụ khác</h4>
                  <div class="owl-carousel" data-nav-arrow="false" data-items="2" data-md-items="2" data-sm-items="2" data-xs-items="1" data-xx-items="1" data-space="30" data-autoheight="true" data-autospeed="6000">
                    @foreach($all_services as $service_item)
                      @if($service_item->id != $service->id)
                    <div class="item">
                      <div class="blog-post blog-post-other">
                        @if($service_item->avatar_file)
                        <div class="blog-post-image">
                          <img class="img-fluid" src="{{ $service_item->avatar_file }}" alt="{{ $service_item->name }}">
                        </div>
                        @endif
                        <div class="blog-post-content">
                          <div class="blog-post-details">
                            <h6 class="blog-post-title">
                            <a href="{{ $service_item->service_url }}">{{ $service_item->name }}</a>
                            </h6>
                            <p class="mb-0">{{ $service_item->description }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                      @endif
                    @endforeach
                  </div>
                </div>
              @endisset  
                @if($comments)
                <hr class="my-4 my-sm-5">
                <div class="comments mt-4 mt-md-5">
                  <h5 class="mb-4"><a id="comments">Nhận xét về dịch vụ</a></h5>
                  @foreach($comments as $comment)
                  <div class="d-flex mb-4">
                    <div class="media-body ms-3 shadow-sm rounded-sm p-3 p-sm-4">
                      <div class="d-flex">
                        <h6 class="mt-0">{{ $comment->name }}</h6>
                        <div class="d-flex ms-auto mb-3">
                          @if($comment->rate > 0)
                          <ul class="list-unstyled d-flex mb-0">
                            {!! parseStar($comment->rate) !!}
                          </ul>
                          @endif
                        </div>
                      </div>
                      @if($comment->subject)<p><strong>{{ $comment->subject }}</strong></p>@endif
                      <p>{{ $comment->content }}</p>
                    </div>
                  </div>
                    @if($comment->admin_reply)
                    <div class="d-flex mb-4 ms-sm-5 ms-4 admin-reply">
                      <div class="media-body ms-3 shadow-sm rounded-sm p-3 p-sm-4">
                        <div class="d-flex">
                          <h6 class="mt-0">XeBaGac</h6>
                        </div>
                        <p>{{ $comment->admin_reply->content }}</p>
                      </div>
                    </div>
                    @endif
                  @endforeach
                </div>
                @endif
                <div class="mt-5">
                  <div class="border">
                    <h6 class="text-dark px-4 py-2 bg-light mb-0"><a id="review"></a>Nhận xét về dịch vụ</h6>
                    <div class="p-4 border-top">
                      <form class="form-flat-style" action="{{ route('service.review') }}#review" method="post">
                        <div class="row">
                            @if ($errors->any())
                            <div class="form-group mb-3 col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>  
                            @endif
                          <div class="form-group mb-3 col-md-12">
                            <div class="ratings">
                              <input type="radio" id="star5" name="ratings" value="5" @php if(old('ratings') == 5){ print 'checked'; }; @endphp /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                              <input type="radio" id="star4half" name="ratings" value="4.5" @php if(old('ratings') == 4.5){ print 'checked'; }; @endphp /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                              <input type="radio" id="star4" name="ratings" value="4" @php if(old('ratings') == 4){ print 'checked'; }; @endphp /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                              <input type="radio" id="star3half" name="ratings" value="3.5" @php if(old('ratings') == 3.5){ print 'checked'; }; @endphp /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                              <input type="radio" id="star3" name="ratings" value="3" @php if(old('ratings') == 3){ print 'checked'; }; @endphp /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                              <input type="radio" id="star2half" name="ratings" value="2.5" @php if(old('ratings') == 2.5){ print 'checked'; }; @endphp /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                              <input type="radio" id="star2" name="ratings" value="2" @php if(old('ratings') == 2){ print 'checked'; }; @endphp /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                              <input type="radio" id="star1half" name="ratings" value="1.5" @php if(old('ratings') == 1.5){ print 'checked'; }; @endphp /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                              <input type="radio" id="star1" name="ratings" value="1" @php if(old('ratings') == 1){ print 'checked'; }; @endphp /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                              <input type="radio" id="starhalf" name="ratings" value="0.5" @php if(old('ratings') == 0.5){ print 'checked'; }; @endphp /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                            </div>
                          </div>
                          <div class="form-group mb-3 col-lg-4">
                            <label class="form-label">Tên của bạn</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                          </div>
                          <div class="form-group mb-3 col-lg-4">
                            <label class="form-label">Địa chỉ e-mail</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                          </div>
                          <div class="form-group mb-3 col-lg-4">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                          </div>
                          <div class="form-group mb-3 col-lg-12">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" name="content" rows="4" >{{ old('content') }}</textarea>
                          </div>
                          <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Gửi nhận xét</button>
                          </div>
                        </div>
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}"/>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5 col-xl-4 mt-4 mt-md-0 order-2 order-lg-1">
              <div class="blog-sidebar">
                <div class="widgets">
                  @if($right_banner)
                  <div class="widget">
                    <a href="{{ $right_banner->link }}"><img src="{{ $right_banner->banner_file }}" alt="{{ $right_banner->name }}" width="366" height="325" /></a>
                  </div>
                  @endif
                  @if($latest_articles)
                  <div class="widget">
                    <h6 class="widget-title">Bài viết</h6>
                    <div class="widget-content">
                      <div class="row">
                        @foreach($latest_articles as $latest_article)
                        <div class="col-12 d-flex mb-3">
                          <div class="recent-post-img avatar avatar-lg me-3">
                            <img class="img-fluid" src="{{ $latest_article->avatar_file }}" alt="{{ $latest_article->title }}">
                          </div>
                          <div class="recent-post-info">  
                            <a href="{{ $latest_article->url_details }}"><b>{{ $latest_article->title }}</b></a>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--=================================
      blog single -->
@stop