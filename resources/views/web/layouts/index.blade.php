<!DOCTYPE html>
<html>
    <head>
        <title>{{ trans('layouts.title') }}</title>
        {{-- Meta --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Bootstrap  --}}
        <link rel="stylesheet" href="{{asset('admin/layout/css/bootstrap.css')}}">
        {{-- Font Awesome --}}
        <link rel="stylesheet" href="{{asset('admin/layout/css/font-awesome.css')}}">
        {{-- Daterange --}}
        <link rel="stylesheet" href="{{asset('libs/daterangepicker/daterangepicker.css')}}">
        {{-- Select 2 --}}
        <link href="{{asset('libs/select2/select2.min.css')}}" rel="stylesheet"/>
        {{-- Toastr --}}
        <link rel="stylesheet" href="{{asset('libs/toastr/toastr.min.css')}}">
        {{-- Custom css --}}
        <link rel="stylesheet" href="{{asset('admin/css/common.css')}}">
        <link rel="stylesheet" href="{{asset('web/css/partial.css')}}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        @yield('css')
    </head>
    <body>
        @yield('content')
        {{-- Jquery --}}
        <script src="{{asset('admin/layout/js/jquery.js')}}"></script>
        {{-- Jquery UI --}}
        <script src="{{asset('admin/layout/js/jquery-ui.js')}}"></script>
        {{-- Resolve confict boostrap tooltip & jquery tooltip --}}
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        {{-- Bootstrap --}}
        <script src="{{asset('admin/layout/js/bootstrap.js')}}"></script>
        <script src="{{asset('libs/inputmask/jquery.inputmask.bundle.min.js')}}"></script>
        {{-- Daterange --}}
        <script src="{{asset('libs/daterangepicker/moment.min.js')}}"></script>
        <script src="{{asset('libs/daterangepicker/daterangepicker.js')}}"></script>
        {{-- toastr --}}
        <script src="{{asset('libs/toastr/toastr.min.js')}}"></script>
        {{-- Select 2 --}}
        <script type="text/javascript" src="{{asset('libs/select2/select2.min.js')}}"></script>
        <script type="text/javascript">
            @php
                echo 'window.server_common=' . json_encode(config('common')) . ';';
            @endphp
        </script>
        {{-- Cookie --}}
        <script type="text/javascript" src="{{asset('libs/cookie/jquery.cookie.js')}}"></script>
        {{-- Common --}}
        <script type="text/javascript" src="{{asset('admin/js/common.js')}}"></script>
        <script type="text/javascript" src="{{asset('web/js/common.js')}}"></script>
        @yield('javascript')
    </body>
</html>
