@extends('admin.master')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="pull-left"><h1>Các bài viết</h1></div>
                <a class="pull-left ml-2" href="{{ route($add_url) }}"><i class="fa fa-plus-circle fa-2x"></i></a>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Bài viết</li>
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
                                    <col />
                                    @if($page_name == 'products')<col width="20%" />@endif
                                    <col width="10%" />
                                    <col width="5%" />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tiêu đề</th>
                                        @if($page_name == 'products')<th>Danh mục</th>@endif
                                        <th>Ngày đăng</th>
                                        <th>Tạo lúc</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $article)
                                    <tr>
                                    <td>
                                        @if ($article->avatar_file != '')
                                        <img src="{{ $article->avatar_file }}" width="100" />
                                        @endif
                                    </td>
                                    <td>{{ $article->title }}</td>
                                    @if($page_name == 'products')<td>{{ $article->category(config('env.LANGUAGE_DEFAULT'))->name }}</td>@endif
                                    <td>{{ $article->publish_time }}</td>
                                    <td>{{ $article->created_time }}</td>
                                    <td>
                                        <a class="btn btn-link btn-sm" href="{{ route($view_url, ['id' => $article->id]) }}"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-link btn-sm" href="{{ route($delete_url, ['id' => $article->id]) }}"><i class="fas fa-trash"></i></a>
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