<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="/images/logo-bg.png" alt="Xưởng May Minh Yến" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">XM Minh Yến</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="/admin_assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            @foreach($admin_menus as $admin_menu)  
                @php
                    $menu_open = '';
                    $menu_active = '';
                    if(in_array(Route::currentRouteName(), $admin_menu['routes'])){
                        $menu_open = 'menu-open';
                        $menu_active = 'active';
                    }
                @endphp
            <li class="nav-item {{$menu_open}}">
                <a href="{{ route($admin_menu['route']) }}" class="nav-link {{$menu_active}}">
                    <i class="nav-icon {{$admin_menu['icon']}}"></i>
                    <p>
                    {{$admin_menu['name']}}
                    @isset($admin_menu['children'])
                    <i class="fas fa-angle-left right"></i>
                    @endisset
                    </p>
                </a>
                @isset($admin_menu['children'])
                    <ul class="nav nav-treeview">
                        @foreach($admin_menu['children'] as $admin_menu_children)
                        <li class="nav-item">
                            <a href="{{ route($admin_menu_children['route']) }}" class="nav-link">
                                <i class="{{$admin_menu_children['icon']}} nav-icon"></i>
                                <p>{{ $admin_menu_children['name'] }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                @endisset
            </li>    
            @endforeach
            @foreach(listStaticHtml() as $static_html)    
                @php
                    $menu_open = '';
                    $menu_active = '';
                    if(strpos(url()->current(), "html/".$static_html['id']) > -1){
                        $menu_open = 'menu-open';
                        $menu_active = 'active';
                    }
                @endphp
            <li class="nav-item {{$menu_open}}">
                <a href="/admin/html/{{ $static_html['id'] }}" class="nav-link {{$menu_active}}">
                    <i class="nav-icon fas fa-file-code"></i>
                    <p>
                    {{$static_html['title']}}
                    </p>
                </a>
            </li>   
            @endforeach
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>