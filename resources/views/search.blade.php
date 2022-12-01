@extends('master')

@section('')
default-transparent
@stop
@section('content')
    <!--=================================
    Inner Header -->
    <section class="inner-header bg-holder bg-overlay-black-80" @php if($top_banner !== null && $top_banner->banner_file) { echo 'style="background-image: url('.$top_banner->banner_file.');"';  }  @endphp>
      <div class="container">
        <div class="row align-items-center mb-5 pb-sm-5 pb-0 position-relative">
          <div class="col-md-12 text-center mb-2 mb-md-0">
            <h1 class="mb-0 text-white display-1 fw-5">Kết quả tìm kiếm</h1>
          </div>
        </div>
      </div>
    </section>
    <!--=================================
    Inner Header -->
    @if($has_result)
    <section class="space-ptb course-details">
      <div class="container">
        <div class="row">
          @foreach($search_results as $item)
          <div class="col-lg-4 col-sm-6 mb-4 pb-2">
            <div class="event">
              <div class="event-img">
                <img class="img-fluid" src="{{ $item['avatar_file'] }}" alt="{{ $item['title'] }}">
                @isset($item['publish_time_part']['day'])
                <div class="event-date">
                  {{ $item['publish_time_part']['day']}}
                  <small>{{ $item['publish_time_part']['month']}}</small>
                  <span class="years">{{ $item['publish_time_part']['year']}}</span>
                </div>
                @endisset
              </div>
              <div class="event-info">
                <h6 class="event-title"><a href="{{ $item['url_details'] }}">{{ $item['title'] }}</a></h6>
                <p>{{ $item['description'] }}</p>
                <a class="btn btn-link" href="{{ $item['url_details'] }}">Xem thêm</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @if($has_pagination)
        <div class="row">
          <div class="col-12 text-center mt-4 mt-md-5">
            {{ $search_results->links('paginator') }}
          </div>
        </div>  
        @endif
      </div>
    </section>
    @endif
@stop