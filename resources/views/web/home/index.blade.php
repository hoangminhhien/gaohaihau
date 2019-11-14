@extends('web.layouts.index')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/home.css') }}">
@stop
@section('content')
    @include('web.home.header')
    @include('web.home.product')
    @include('web.partials.footer')
@stop
@section('javascript')
    <script type="text/javascript" src="{{ asset('web/js/home.js') }}"></script>
    <script src="{{asset('web/js/product.js')}}"></script>
@stop
