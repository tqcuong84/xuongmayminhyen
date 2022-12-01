@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thông tin danh mục sản phẩm</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.product.categories') }}">Danh mục sản phẩm</a></li>
                <li class="breadcrumb-item active">Thông tin danh mục sản phẩm</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.product.category.postUpdate') }}" method="POST">
                @csrf
            <div class="row">
                @if ($result == 'success')
                <div class="col-md-12">
                    <div class="alert alert-success text-center " role="alert">
                        Thông tin danh mục sản phẩm đã được lưu thành công
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
                            <h3 class="card-title">Thông tin danh mục</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tên danh mục</label>
                                <input type="text" name="name" class="form-control" value="{{$service_category->name}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" name="description">{{$service_category->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin SEO</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label >Meta title</label>
                                <input type="text" name="name_seo" class="form-control" value="{{$service_category->name_seo}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Meta description</label>
                                <textarea class="form-control" name="description_seo">{{$service_category->description_seo}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta keyword</label>
                                <textarea class="form-control" name="keyword">{{$service_category->keyword}}</textarea>
                            </div>
                        </div>    
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình đại diện (1300x650)</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="avatar"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"
                                input_file_name="avatar_file"
                                input_folder_name="avatar_folder"
                                input_folder_name="avatar_folder"
                                input_file_name_value="{{ $service_category->image }}"
                                input_folder_name_value="{{ $service_category->folder }}"
                                file_uploaded="{{ $service_category->avatar_file }}"
                            >
                            </upload-file-component>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình banner chính (1920x500)</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="main_banner"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"  
                                input_file_name="main_banner_file"
                                input_folder_name="main_banner_folder"
                                input_file_name_value="{{ $service_category->image2 }}"
                                input_folder_name_value="{{ $service_category->folder }}"
                                file_uploaded="{{ $service_category->main_banner_file }}"
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
                                <input class="custom-control-input" type="checkbox" name="active" id="active" value="1" @php print($service_category->active?'checked':''); @endphp />
                                <label for="active" class="custom-control-label">Hiện trên trang</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                        </div>
                    </div>
                </div>
            </div>
                <input type="hidden" value="{{ $service_category->id }}" name="id" />
            </form>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop