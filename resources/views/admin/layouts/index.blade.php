<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ trans('layouts.title') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('admin/layout/css/bootstrap.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/layout/css/font-awesome.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/layout/css/AdminLTE.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('admin/layout/css/_all-skins.css')}}">
  <link rel="stylesheet" href="{{asset('libs/daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('libs/toastr/toastr.min.css')}}">
  <link href="{{asset('libs/select2/select2.min.css')}}" rel="stylesheet"/>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="{{asset('admin/css/common.css')}}">
  <link rel="stylesheet" href="{{asset('admin/css/partial.css')}}">
  <link rel="stylesheet" href="{{asset('admin/css/layout.css')}}">
  @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('admin.deliveries')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{ trans('layouts.rice') }} <b>{{ trans('layouts.hai_hau') }}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{ trans('layouts.rice') }} <b>{{ trans('layouts.hai_hau') }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          @include('admin.partials.notification')
          <!-- Control Sidebar Toggle Button -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>
            <ul class="dropdown-menu" style="width: 135px;">
              <li class="header">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ trans('auth.logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('admin/layout/img/user_profile.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      @include('admin.layouts.menu')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('admin.partials.loading')
    <section class="content-header">
        @yield('content_header')
    </section>
    <section class="content">
        @yield('content')
    </section>
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{asset('admin/layout/js/jquery.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('admin/layout/js/jquery-ui.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('admin/layout/js/bootstrap.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/layout/js/adminlte.js')}}"></script>
<script src="{{asset('libs/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('libs/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('libs/toastr/toastr.min.js')}}"></script>
<script src="{{asset('libs/inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script type="text/javascript">
    @php
        echo 'window.server_common=' . json_encode(config('common')) . ';';
    @endphp
    window.$user = {!! json_encode(auth()->user()) !!};
</script>
<script src="{{asset('admin/js/common.js')}}"></script>
{{-- socket --}}
<script src="{{asset('libs/laravel-echo/echo.js')}}"></script>
<script src="{{asset('libs/socket.io-client/socket.io.js')}}"></script>
<script src="{{asset('admin/js/admin.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('libs/select2/select2.min.js')}}"></script>
@yield('notification_javascript')
@yield('javascript')
</body>
</html>