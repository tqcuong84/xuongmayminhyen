<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Xưởng May Minh Yến | Trang Quản trị</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/blueimp-file-upload/css/jquery.fileupload-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/blueimp-file-upload/css/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/dist/css/custom.css') }}?v=3">
    <script src="{{ asset('/admin_assets/plugins/ckeditor/ckeditor.js') }}"></script>
    @yield('head')
    <script>
        window.get_districts_url = "{{ route('admin.get-districts') }}";
        window.get_wards_url = "{{ route('admin.get-wards') }}";
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" id="app">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/images/logo.png" alt="Xưởng May Minh Yến" width="60">
        </div>
        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')
        @yield('content')
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 Quản trị Xưởng May Minh Yến</strong>
            All rights reserveds
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <ul>
                <li><a href="javascript: void(0)" onClick="$('#logout-form').submit();">Logout</a></li>
            </ul>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="post">
                @csrf
            </form>
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin_assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin_assets/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('admin_assets/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('admin_assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('admin_assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('admin_assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('admin_assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('admin_assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{ asset('admin_assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{ asset('admin_assets/plugins/blueimp-file-upload/js/vendor/jquery.ui.widget.js')}}"></script>
    <script src="{{ asset('admin_assets/plugins/blueimp-file-upload/js/jquery.iframe-transport.js')}}"></script>
    <script src="{{ asset('admin_assets/plugins/blueimp-file-upload/js/jquery.fileupload.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>   

    <script src="{{ asset('admin_assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/select2/js/i18n/vi.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('admin_assets/dist/js/adminlte.js')}}"></script>
    <script type="text/javascript" src="{{ asset(mix('admin_assets/js/admin_app.js')) }}"></script>
    @yield('js')
</body>
</html>    