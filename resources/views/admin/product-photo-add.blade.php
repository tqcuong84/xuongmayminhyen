@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm hình ảnh sản phẩm</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.product-photos') }}">Hình ảnh sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm hình ảnh</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.product-photo.postAdd') }}" method="POST">
                @csrf
            <div class="row">
                @if ($result == 'success')
                <div class="col-md-12">
                    <div class="alert alert-success text-center " role="alert">
                    Hình ảnh sản phẩm đã được tạo thành công
                    </div>
                </div>
                @elseif ($errors->any())
                <div class="col-md-12">
                    <div class="alert alert-danger text-center " role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="">
                            </div>
                        </div>
                    </div> 
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="product_photos"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"
                                input_folder_name="product_photo_folder"
                                input_folder_name_value="{{ old('product_photo_folder') }}"
                                multi_file_name_uploaded="{{ old('multi_file_name_post') }}"
                                multiple="true"
                            >
                            </upload-file-component>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình đại diện (900x715)</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="avatar"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"
                                input_file_name="avatar_file"
                                input_folder_name="avatar_folder"
                                input_file_name_value="{{ old('avatar_file') }}"
                                input_folder_name_value="{{ old('folder') }}"
                                file_uploaded="{{ old('avatar_file_post') }}"
                            >
                            </upload-file-component>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Tùy chọn</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="hotnews" id="hotnews" value="1">
                                <label for="hotnews" class="custom-control-label">Hình nổi bật</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="is_homepage" id="is_homepage" value="1">
                                <label for="is_homepage" class="custom-control-label">Hiện trên trang chủ</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="active" id="active" value="1" checked>
                                <label for="active" class="custom-control-label">Hiện trên trang</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop