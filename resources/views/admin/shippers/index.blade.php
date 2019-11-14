<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no" />
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
        <link rel="stylesheet" href="{{ asset('admin/css/shipper.css')}}">
        <link rel="stylesheet" href="{{asset('libs/select2/select2.min.css')}}"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{asset('admin/css/common.css')}}">
        <link rel="stylesheet" href="{{asset('admin/css/partial.css')}}">
        @yield('css')
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <nav class="navbar navbar-static-top theme-bg-i header">
            <div class="navbar-custom-menu">
                <div class="header-title">{{ trans('layouts.title') }}</div>
                <ul class="nav navbar-nav notification-icon">
                    @include('admin.partials.notification')
                </ul>
                <ul class="nav navbar-nav notification-icon-logout">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                        <ul class="dropdown-menu">
                            <li class="header center_dropdown size_dropdown">
                                <span><i class="fa fa-user-circle-o"></i></span>
                                <span>{{Auth::user()->name}}<span>
                            </li>
                            <li class="header center_dropdown color-red">
                                <span><i class="fa fa-power-off"></i></span>
                                <span><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ trans('auth.logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                    </form>
                                </span>
                            </li>
                        </ul>
                    </li>
                </ul>    
            </div>
        </nav>
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs  navbar-fixed-top fix-nav-bar fix-navbar">
            <li class="active"><a href="#delivery-tab" class="delivery-tab" data-toggle="tab"><strong>{{trans('shipper.delivery')}}</strong>
                </a>
            </li>
            <li><a href="#history-tab" class="history-tab" data-toggle="tab"><strong>{{trans('shipper.history')}}</strong></a></li>
        </ul>
        <section class="content common-content">
            <div class="common-content-child">
                <div class="tab-content">
                    <div id="delivery-tab" class="tab-pane active">
                        @include('admin.shippers._delivery')
                    </div>
                    <div class="tab-pane" id="history-tab">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <select class="form-control select2 selectTime" id="select-time" style="width: 100%" disable_search="true">
                                    @foreach(config('common.history_date') as $key => $value)
                                        <option value="{{$value}}">
                                            {{ trans('shipper.date_history_option.'.$key)}} 
                                        </option>
                                    @endforeach 
                                    <option value="ALL">
                                        {{trans('shipper.date_history_option.all')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="history-tab-content">
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.shippers._delivery_modal')
        </section>
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
        <script type="text/javascript" src="{{asset('libs/select2/select2.min.js')}}"></script>
        <script type="text/javascript">
            @php
                echo 'window.server_common=' . json_encode(config('common')) . ';';
            @endphp
            window.$user = {!! json_encode(auth()->user()) !!};
        </script>
        {{-- socket --}}
        <script src="{{asset('libs/laravel-echo/echo.js')}}"></script>
        <script src="{{asset('libs/socket.io-client/socket.io.js')}}"></script>
        <script type="text/javascript" src="{{asset('admin/lang/shipper.js')}}"></script>
        <script src="{{asset('admin/js/common.js')}}"></script>
        <script src="{{asset('admin/js/admin.js')}}"></script>
        <script src="{{ asset('admin/js/shipper.js') }}"></script>
        <script>
            var route_index = '{!! route('admin.shippers') !!}';
        </script>

        @yield('notification_javascript')
        @yield('javascript')
    </body>
</html>