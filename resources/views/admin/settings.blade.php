@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cài đặt hệ thống</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Cài đặt hệ thống</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.settings.postUpdate') }}" method="POST">
                @csrf
                <div class="row">
                    @if ($result == 'success')
                    <div class="col-md-12">
                        <div class="alert alert-success text-center " role="alert">
                            Cài đặt hệ thống đã được lưu thành công
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin liên hệ</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{settings('address')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{settings('phone')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="text" name="site-email" class="form-control" value="{{settings('site-email')}}" placeholder="">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">SEO Trang chủ</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>H1</label>
                                    <input type="text" name="h1-home-page" class="form-control" value="{{settings('h1-home-page')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Page title</label>
                                    <input type="text" name="page-title" class="form-control" value="{{settings('page-title')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" name="meta-description">{{settings('meta-description')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta keyword</label>
                                    <textarea class="form-control" name="meta-keyword">{{settings('meta-keyword')}}</textarea>
                                </div>
                            </div>    
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">SEO Trang Kinh Nghiệm Gia Công</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Page title</label>
                                    <input type="text" name="article-page-title" class="form-control" value="{{settings('article-page-title')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" name="article-meta-description">{{settings('article-meta-description')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta keyword</label>
                                    <textarea class="form-control" name="article-meta-keyword">{{settings('article-meta-keyword')}}</textarea>
                                </div>
                            </div>    
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">SEO Trang Hình Ảnh Sản Phẩm</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Page title</label>
                                    <input type="text" name="product-photos-page-title" class="form-control" value="{{settings('product-photos-page-title')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" name="product-photos-meta-description">{{settings('product-photos-meta-description')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta keyword</label>
                                    <textarea class="form-control" name="product-photos-meta-keyword">{{settings('product-photos-meta-keyword')}}</textarea>
                                </div>
                            </div>    
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>    
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Xưởng May Cho Mọi Giấc Mơ</h3>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" name="xuong-may-cho-moi-giac-mo" id="xuong-may-cho-moi-giac-mo">{{settings('xuong-may-cho-moi-giac-mo')}}</textarea>
                            </div>    
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>     
                    </div>
                    <div class="col-md-6">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Mạng xã hội</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="text" name="facebook-link" class="form-control" value="{{settings('facebook-link')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Twitter</label>
                                    <input type="text" name="twitter-link" class="form-control" value="{{settings('twitter-link')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Youtube</label>
                                    <input type="text" name="youtube-link" class="form-control" value="{{settings('youtube-link')}}" placeholder="">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">SEO Trang Sản Phẩm</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Page title</label>
                                    <input type="text" name="product-page-title" class="form-control" value="{{settings('product-page-title')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" name="product-meta-description">{{settings('product-meta-description')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta keyword</label>
                                    <textarea class="form-control" name="product-meta-keyword">{{settings('product-meta-keyword')}}</textarea>
                                </div>
                            </div>    
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">SEO Trang Gallery</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Page title</label>
                                    <input type="text" name="galleries-page-title" class="form-control" value="{{settings('galleries-page-title')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" name="galleries-meta-description">{{settings('galleries-meta-description')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Meta keyword</label>
                                    <textarea class="form-control" name="galleries-meta-keyword">{{settings('galleries-meta-keyword')}}</textarea>
                                </div>
                            </div>    
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>      
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Kinh Nghiệm Gia Công (banner trang chủ)</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Main text</label>
                                    <input type="text" name="article-home-page-banner-main-text" class="form-control" value="{{settings('article-home-page-banner-main-text')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Sub text</label>
                                    <input type="text" name="article-home-page-banner-sub-text" class="form-control" value="{{settings('article-home-page-banner-sub-text')}}" placeholder="">
                                </div>
                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="article-home-page-banner-text-visibility" name="article-home-page-banner-text-visibility" value="1" @php print(settings('article-home-page-banner-text-visibility')?'checked':''); @endphp />
                                    <label for="article-home-page-banner-text-visibility" class="custom-control-label">Hiện trên trang</label>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Ô 1</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" placeholder="Số" name="article-home-page-banner-number-block-1" value="{{settings('article-home-page-banner-number-block-1')}}">
                                        <input class="form-control" type="text" placeholder="Nội dung" name="article-home-page-banner-text-block-1" value="{{settings('article-home-page-banner-text-block-1')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ô 2</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" placeholder="Số" name="article-home-page-banner-number-block-2" value="{{settings('article-home-page-banner-number-block-2')}}">
                                        <input class="form-control" type="text" placeholder="Nội dung" name="article-home-page-banner-text-block-2" value="{{settings('article-home-page-banner-text-block-2')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ô 3</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" placeholder="Số" name="article-home-page-banner-number-block-3" value="{{settings('article-home-page-banner-number-block-3')}}">
                                        <input class="form-control" type="text" placeholder="Nội dung" name="article-home-page-banner-text-block-3" value="{{settings('article-home-page-banner-text-block-3')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ô 4</label>
                                    <div class="input-group">
                                        <input class="form-control" type="number" placeholder="Số" name="article-home-page-banner-number-block-4" value="{{settings('article-home-page-banner-number-block-4')}}">
                                        <input class="form-control" type="text" placeholder="Nội dung" name="article-home-page-banner-text-block-4" value="{{settings('article-home-page-banner-text-block-4')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary pull-right">Lưu thông tin</button>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Đối Tác Của Chúng Tôi</h3>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" name="doi-tac-cua-chung-toi" id="doi-tac-cua-chung-toi">{{settings('doi-tac-cua-chung-toi')}}</textarea>
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
@section("js")
<script>
    $(document).ready(function(){
        const _token = $('meta[name="csrf-token"]').attr('content');
        CKEDITOR.replace("xuong-may-cho-moi-giac-mo",{
            height: "300px",
            filebrowserUploadUrl: "/admin/ckeditor/image_upload?_token=" + _token,
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace("doi-tac-cua-chung-toi",{
            height: "300px",
            filebrowserUploadUrl: "/admin/ckeditor/image_upload?_token=" + _token,
            filebrowserUploadMethod: 'form'
        });
    });
</script>
@stop