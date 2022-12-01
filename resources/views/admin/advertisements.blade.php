@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="pull-left"><h1>Banner quảng cáo</h1></div>
                <a class="pull-left ml-2" href="{{ route('admin.advertisement.add') }}"><i class="fa fa-plus-circle fa-2x"></i></a>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Banner quảng cáo</li>
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
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <colgroup>
                                    <col width="5%" />
                                    <col width="5%" />
                                    <col width="30%" />
                                    <col width="20%" />
                                    <col width="20%" />
                                    <col width="10%" />
                                    <col width="5%" />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th></th>
                                        <th>Tên quảng cáo</th>
                                        <th>Vị trí</th>
                                        <th>Thời gian</th>
                                        <th>Tạo lúc</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($advertisements as $advertisement)
                                    <tr>
                                    <td>{{ $advertisement->id }}</td>
                                    <td>
                                        <img src="{{ $advertisement->banner_file }}" width="100" />
                                    </td>
                                    <td>{{ $advertisement->name }}</td>
                                    <td>{{ $advertisement->banner_location }}</td>
                                    <td>
                                        @if($advertisement->start_date_time != '')
                                            {{ $advertisement->start_date_time }} -> {{ $advertisement->end_date_time }}
                                        @endif 
                                    </td>
                                    <td>{{ $advertisement->created_time }}</td>
                                    <td>
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.advertisement.view', ['id' => $advertisement->id]) }}"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.advertisement.delete', ['id' => $advertisement->id]) }}"><i class="fas fa-trash"></i></a>
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