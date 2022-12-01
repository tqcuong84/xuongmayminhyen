@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $static_html->title }}</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">{{$static_html->title}}</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.html.postUpdate', ['id' => $static_html->id]) }}" method="POST">
                @csrf
                <div class="row">
                    @if ($result == 'success')
                    <div class="col-md-12">
                        <div class="alert alert-success text-center " role="alert">
                            Cài đặt hệ thống đã được lưu thành công
                        </div>
                    </div>
                    @endif
                    <div class="col-md-8">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Nội dung</h3>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" name="content" id="editor_content">{{$static_html->content}}</textarea>
                            </div>  
                        </div>  
                    </div>    
                    <div class="col-md-4">
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
                                    input_file_name_value="{{ $static_html->banner_file }}"
                                    input_folder_name_value="{{ $static_html->folder }}"
                                    file_uploaded="{{ $static_html->main_banner_file }}"
                                >
                                </upload-file-component>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin SEO</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label >Meta title</label>
                                    <input type="text" name="page_title" class="form-control" value="{{$static_html->page_title}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" name="meta_description">{{$static_html->meta_description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta keyword</label>
                                    <textarea class="form-control" name="meta_keyword">{{$static_html->meta_keyword}}</textarea>
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