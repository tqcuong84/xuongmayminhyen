@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm bài viết</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ $list_url }}">Bài viết</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ $form_action }}" method="POST">
                @csrf
            <div class="row">
                @if ($errors->any())
                <div class="col-md-12">
                    <div class="alert alert-danger text-center " role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
                @elseif ($result == 'success')
                <div class="col-md-12">
                    <div class="alert alert-success text-center " role="alert">
                        Thông tin bài viết đã được tạo thành công
                    </div>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin bài viết</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" name="description">{{old('description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="content" id="editor_content">{{old('content')}}</textarea>
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
                                <input type="text" name="title_seo" class="form-control" value="{{old('title_seo')}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Meta description</label>
                                <textarea class="form-control" name="description_seo">{{old('description_seo')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta keyword</label>
                                <textarea class="form-control" name="keyword">{{old('keyword')}}</textarea>
                            </div>
                        </div>    
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình đại diện (745x370)</h3>
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
                            <h3 class="card-title">Hình banner chính (1920x600)</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="main_banner"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"  
                                input_file_name="main_banner_file"
                                input_folder_name="main_banner_folder"
                                input_file_name_value="{{ old('main_banner_file') }}"
                                input_folder_name_value="{{ old('folder') }}"
                                file_uploaded="{{ old('main_banner_file_post') }}"
                            >
                            </upload-file-component>
                        </div>
                    </div>
                    @if($page_name == 'products')
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Danh mục</h3>
                        </div>
                        <div class="card-body">
                            <select class="form-control" name="category_id">
                                <option value="" selected></option>
                                @foreach($product_categories as $product_category)
                                    <option value="{{ $product_category['id'] }}" @php if(old('category_id') == $product_category['id']) print "selected"; @endphp>{{ $product_category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endisset
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Ngày đăng</h3>
                        </div>
                        <div class="card-body">
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="publish_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ old('publish_date') }}"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Tùy chọn</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="hotnews" id="hotnews" value="1">
                                <label for="hotnews" class="custom-control-label">Bài viết nổi bật</label>
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
@section('js')
<script>
    $(function () {
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@stop