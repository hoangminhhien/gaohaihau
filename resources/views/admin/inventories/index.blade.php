@extends('admin.layouts.index')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/inventory.css') }}">
@stop
@section('content_header')
    <h1><i class="fa fa-bank"></i> {{ trans('inventory.inventory_title') }}</h1>
@stop
@section('content')
<div class="container-fluid">
    <div class="row row-background">
        <div class="box box-primary col-sm-12">
            @include('admin.inventories.create')
            <div class="row">
                <div class="col-sm-12" id="table_container">
                    @include('admin.inventories._table_index')
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Notification when success --}}
@include('admin.partials.toastr')

{{-- Delete confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_delete',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('inventory.delete_confirm.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'confirmDelete',
])

@stop
@section('javascript')
    <script type="text/javascript">
        window.createInventoryUrl = "{!! route('admin.inventories.create') !!}";
    </script>
    <script type="text/javascript" src="{{asset('admin/lang/common.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/lang/inventory.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/inventory.js')}}"></script>
@stop