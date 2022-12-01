@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thông tin thương hiệu</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.brands') }}">Thương hiệu</a></li>
                <li class="breadcrumb-item active">Thông tin thương hiệu</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.brand.postUpdate') }}" method="POST">
                @csrf
            <div class="row">
                @if ($result == 'success')
                <div class="col-md-12">
                    <div class="alert alert-success text-center " role="alert">
                    Thương hiệu đã được lưu thành công
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
                                <input type="text" name="title" class="form-control" value="{{$article->title}}" placeholder="">
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình đại diện (270x95)</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="avatar"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"
                                input_file_name="avatar_file"
                                input_folder_name="avatar_folder"
                                input_folder_name="avatar_folder"
                                input_file_name_value="{{ $article->image }}"
                                input_folder_name_value="{{ $article->folder }}"
                                file_uploaded="{{ $article->avatar_file }}"
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
                                <input class="custom-control-input" type="checkbox" name="is_homepage" id="is_homepage" value="1" @php print($article->is_homepage?'checked':''); @endphp />
                                <label for="is_homepage" class="custom-control-label">Hiện trên trang chủ</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="active" id="active" value="1" @php print($article->active?'checked':''); @endphp />
                                <label for="active" class="custom-control-label">Hiện trên trang</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                        </div>
                    </div>
                </div>
            </div>
                <input type="hidden" value="{{ $article->id }}" name="id" />
            </form>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop