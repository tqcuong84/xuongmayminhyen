@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="pull-left"><h1>Danh sách quản trị viên</h1></div>
                <a class="pull-left ml-2" href="{{ route('admin.user.add') }}"><i class="fa fa-plus-circle fa-2x"></i></a>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Quản trị viên</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap">
                                <colgroup>
                                    <col width="5%" />
                                    <col width="30%" />
                                    <col width="30%" />
                                    <col width="10%" />
                                    <col width="5%" />
                                </colgroup>
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>Tên nhân viên</th>
                                    <th>Số điện thoại</th>
                                    <th>Đăng nhập lần cuối</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staffs as $staff)
                                    <tr>
                                    <td>{{ $staff->id }}</td>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->phone }}</td>
                                    <td>{{ $staff->last_login_time }}</td>
                                    <td>
                                        @if(!$staff->hasRole('admin'))
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.user.view', ['id' => $staff->id]) }}"><i class="fas fa-user-edit"></i></a>
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.user.delete', ['id' => $staff->id]) }}"><i class="fas fa-trash"></i></a>
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop