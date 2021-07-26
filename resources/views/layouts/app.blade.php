<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ses Servisi | @yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" class="nav-link">Anasayfa</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item d-none">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Ara"
                                   aria-label="Ara">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-link elevation-4">
            <img src="{{ asset('dist/img/ses-servisi-logo.png') }}" alt="Ses Servisi" class="brand-image"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Depo Kiralama</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <span class="text-muted">Giriş Yapmış Kullanıcı</span>
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    <a class="text-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <small>{{ __('Logout') }}</small>
                    </a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline d-none">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Ara"
                           aria-label="Ara">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Anasayfa</p>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'depots.show' || Route::currentRouteName() == 'depots.showMaintenance' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{Route::currentRouteName() == 'depots.show' || Route::currentRouteName() == 'depots.showMaintenance' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                Depolar
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach($menuDepots as $depot)
                                <li class="nav-item">
                                    <a href="{{route('depots.show', ['depot' => $depot])}}" class="nav-link {{ (request()->is('depots*') && request()->segment(2) == $depot->id) ? 'active' : '' }}">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <p>{{ $depot->name }}</p>
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a href="{{route('depots.showMaintenance')}}" class="nav-link {{Route::currentRouteName() == 'depots.showMaintenance' ? 'active' : '' }}">
                                    <i class="fas fa-tools nav-icon"></i>
                                    <p>Ölçü/Bakım</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'rentForms.create' || Route::currentRouteName() == 'rentForms.index' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-business-time"></i>
                            <p>
                                Kiralamalar
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('rentForms.create') }}" class="nav-link {{Route::currentRouteName() == 'rentForms.create' ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Yeni Kiralama</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rentForms.index') }}" class="nav-link {{Route::currentRouteName() == 'rentForms.index' ? 'active' : '' }}">
                                    <i class="fas fa-clipboard-check nav-icon"></i>
                                    <p>Kiralamalar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">Yönetim</li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Kullanıcılar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('depots.index') }}" class="nav-link {{ Route::currentRouteName() != 'depots.show' && Route::currentRouteName() != 'depots.showMaintenance' && request()->is('depots*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Depolar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>Kategoriler</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box-open"></i>
                            <p>Malzemeler</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('companies.index') }}" class="nav-link {{ request()->is('companies*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Firmalar</p>
                        </a>
                    </li>
                    <li class="nav-header d-none">Raporlar</li>
                    <li class="nav-item d-none">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Kiralama Raporları
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>...</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item d-none">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Malzeme Raporları
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>...</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('content-title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Anasayfa</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success')}}
                    </div>
                @endif
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Versiyon</b> 1.0.0 |
            <small class="text-muted"> Created by <a href="https://halilcagriakkuzu.com">Halil Çağrı AKKUZU</a>.</small>
        </div>
        <strong>&copy; 2021 Ses Servisi</strong>.
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@yield('js')
</body>
</html>
