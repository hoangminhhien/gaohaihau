@extends('admin.layouts.index')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/master_data.css') }}">
@stop
@section('content')
<div class=" docs-premium-template">
    <div class="rows">
        <div class="col-sm-12 col-md-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-bookmark"></i></span>
                <div class="info-box-content">
                    <a href="{{route('admin.projects.index')}}" class="info-box-text">{{trans('master_data.project')}}</a>
                </div>
            </div>
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-home"></i></span>
                <div class="info-box-content">
                    <a href="{{ route('admin.crm') }}" class="info-box-text">{{trans('master_data.crm')}}</a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-question-circle-o"></i></span>
                <div class="info-box-content">
                    <a href="#" class="info-box-text">{{trans('master_data.todo')}}</a>
                </div>
            </div>
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-question-circle-o"></i></span>
                <div class="info-box-content">
                    <a href="#" class="info-box-text">{{trans('master_data.todo')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection