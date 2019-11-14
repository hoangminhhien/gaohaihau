@extends('admin.layouts.index')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/customer.css')}}">
@stop
@section('content')
@section('content_header')
<h1><i class="fa fa-tasks" aria-hidden="true"></i> {{$projects['project_code']}} - {{$projects['name']}}
@if(!empty($customers))
@foreach($customers as $customer)
 : {{$customer['building_code']}} / {{$customer['room_no']}}
@endforeach
@endif</h1>
@stop

@if($errors->any())
    <div id="error">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="box">
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <th style="width: 40%">{{trans('customer.name')}}</th>
                    <th style="width: 40%">{{trans('customer.phone')}}</th>
                    <th style="width: 20%">{{trans('customer.action')}}</th>
                </tr>
                @foreach($customers as $customer)
                 <tr>
                    <td>{{$customer['name']}}</td>
                    <td>{{$customer['phone']}}</td>
                    <td>
                        <button type="button" class="btn btn-danger delete-button" data-href="{{ route('admin.customer.delete', $customer->id) }}" id="delete-button">{{trans('customer.detele_customer')}}</i>
                        </button>
                        <a href="{{route('admin.customer.show', $customer->id)}}">
                            <button type="button" class="btn btn-warning">{{trans('customer.detail_customer')}}
                            </button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
</div>
@stop
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_delete',
    'title' => trans('project.title'),
    'body' => trans('project.body'),
    'submit_label' => trans('project.submit_label'),
    'cancel_label' => trans('project.cancel_label'),
    'callback' => 'confirmDelete',
])
@section('javascript')
    <script type="text/javascript" src="{{asset('admin/js/customer.js')}}"></script>
@stop