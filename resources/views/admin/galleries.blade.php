@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="pull-left"><h1>Hình ảnh sản phẩm</h1></div>
                <a class="pull-left ml-2" href="{{ route('admin.product-photo.add') }}"><i class="fa fa-plus-circle fa-2x"></i></a>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Hình ảnh sản phẩm</li>
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
                            <table class="table table-head-fixed">
                                <colgroup>
                                    <col width="15%" />
                                    <col />
                                    <col width="8%" />
                                    <col width="8%"/>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Tiêu đề</th>
                                        <th>Tạo lúc</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $product_photo)
                                    <tr>
                                    <td>
                                        @if ($product_photo->avatar_file != '')
                                        <img src="{{ $product_photo->avatar_file }}" width="100" />
                                        @endif
                                    </td>
                                    <td>{{ $product_photo->title }}</td>
                                    <td>{{ $product_photo->created_time }}</td>
                                    <td>
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.product-photo.view', ['id' => $product_photo->id]) }}"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-link btn-sm" href="{{ route('admin.product-photo.delete', ['id' => $product_photo->id]) }}"><i class="fas fa-trash"></i></a>
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @if($has_pagination)
                        <div class="card-footer">
                            <div class="pagination-container">
                                {{ $articles->links() }}
                            </div>
                        </div>
                        @endif
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