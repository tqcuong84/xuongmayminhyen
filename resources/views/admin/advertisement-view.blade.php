@extends('admin.master')

@section('head')
<script src="{{ asset('/admin/plugins/ckeditor/ckeditor.js') }}"></script>
@stop
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thông tin banner quảng cáo</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.advertisements') }}">Banner quảng cáo</a></li>
                <li class="breadcrumb-item active">Thông tin quảng cáo</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.advertisement.postUpdate') }}" method="POST">
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
                        Thông tin quảng cáo đã được lưu thành công
                    </div>
                </div>
                @endif
                <div class="col-md-8">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin quảng cáo</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tên quảng cáo</label>
                                <textarea class="form-control" name="name">{{$advertisement->name}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Liên kết</label>
                                <input type="text" name="link" class="form-control" value="{{$advertisement->link}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" name="note">{{$advertisement->note}}</textarea>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Vị trí</h3>
                        </div>
                        <div class="card-body">
                            <select name="location" class="form-control">
                                <option value="0" selected></option>
                            @foreach($advertisement_location as $advertisement_location_key => $advertisement_location_name)
                                <option value="{{ $advertisement_location_key }}" @php echo (($advertisement_location_key == $advertisement->location)?'selected':'') @endphp >{{ $advertisement_location_name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh quảng cáo</h3>
                        </div>
                        <div class="card-body">
                            <upload-file-component
                                wrapper_id="banner_file"
                                upload_url="{{ route('admin.upload_file') }}"  
                                file_type="images/*"
                                input_file_name="banner_file"
                                input_folder_name="banner_folder"
                                input_file_name_value="{{ $advertisement->image }}"
                                input_folder_name_value="{{ $advertisement->folder }}"
                                file_uploaded="{{ $advertisement->banner_file }}"
                            >
                            </upload-file-component>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Thời gian quảng cáo</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Từ ngày</label>
                                <div class="input-group date" id="from_date" data-target-input="nearest">
                                    <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#from_date" value="{{ $advertisement->start_date_time }}"/>
                                    <div class="input-group-append" data-target="#from_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Đến ngày</label>
                                <div class="input-group date" id="to_date" data-target-input="nearest">
                                    <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#to_date" value="{{ $advertisement->end_date_time }}"/>
                                    <div class="input-group-append" data-target="#to_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
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
                                <input class="custom-control-input" type="checkbox" name="active" id="active" value="1" @php print($advertisement->active?'checked':''); @endphp>
                                <label for="active" class="custom-control-label">Hiện trên trang</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                        </div>
                    </div>
                </div>
            </div>
                <input type="hidden" value="{{ $advertisement->id }}" name="id" />
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
        $('#from_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#to_date').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>
@stop