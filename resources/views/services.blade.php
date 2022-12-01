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
            <h1 class="mb-0 text-white display-1 fw-5">{{ $service_category->name }}</h1>
          </div>
        </div>
      </div>
    </section>
    <!--=================================
    Inner Header -->

    @isset($services)
    <!--=================================
    News -->
    <section class="space-ptb service-list">
      <div class="container">
        <div class="row">
          @foreach($services as $service_item)

          <div class="col-sm-6 mb-4 pb-2">
            <div class="course">
              <div class="course-img">
                <img class="img-fluid" src="{{ $service_item->avatar_file }}" alt="{{ $service_item->name }}">
              </div>
              <div class="course-info">
                <div class="course-title">
                  <a href="{{ $service_item->service_url }}">{{ $service_item->name }}</a>
                </div>
                <p class="mb-0">{{ $service_item->description }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    <!--=================================
    News -->
    @endisset
@stop