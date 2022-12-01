@extends('master')

@section('content')
<!--=================================
    Inner Header -->
    <section class="inner-header bg-holder bg-overlay-black-90" style="background-image: url('images/bg/03.jpg');">
        <div class="container">
        <div class="row align-items-center position-relative">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
            <h1 class="breadcrumb-title mb-0 text-white">Lỗi 404</h1>
            </div>
            <div class="col-md-6">
            <ol class="breadcrumb d-flex justify-content-center justify-content-md-end ms-auto">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home me-1"></i>Trang chủ</a></li>
                <li class="breadcrumb-item active"><span>Lỗi 404</span></li>
            </ol>
            </div>
        </div>
        </div>
    </section>
    <!--=================================
    Inner Header -->

    <!--=================================
    Error 404 -->
    <section class="space-ptb">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
            <div class="error-404 text-center">
                <h1>404</h1>
                <h4>Xin lỗi, không tìm thấy thông tin bạn đang quan tâm</h4>
                <p>Không thể tìm thấy những gì bạn đang tìm kiếm? Hãy dành một chút thời gian và thực hiện tìm kiếm bên dưới hoặc bắt đầu từ <a href="/"> Trang chủ</a></p>
                <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form class="form-inline input-with-btn" method="GET" action="{{ route('search') }}">
                    <div class="mb-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm…">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    <!--=================================
    Error 404 -->
@stop