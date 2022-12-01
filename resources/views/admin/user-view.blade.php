@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thông tin quản trị viên</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Quản trị viên</a></li>
                <li class="breadcrumb-item active">Thông tin</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.user.postUpdate') }}" method="POST">
                @csrf
            <div class="row">
                @if ($result == 'success')
                <div class="col-8 offset-2">
                    <div class="alert alert-success text-center " role="alert">
                        Thông tin quản trị viên đã được lưu thành công
                    </div>
                </div>
                @elseif ($errors->any())
                <div class="col-8 offset-2">
                    <div class="alert alert-danger text-center " role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="col-4 offset-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin cá nhân</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ tên</label>
                                <input type="text" name="name" class="form-control" value="{{$staff->name}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="{{$staff->phone}}"  placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin đăng nhập</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" value="{{$staff->email}}" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu</label>
                                <input type="password" name="password" class="form-control"  placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nhập lại mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control"  placeholder="">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                        </div>
                    </div>
                </div>
            </div>
                <input type="hidden" name="id" value="{{ $staff->id }}"/>
            </form>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop