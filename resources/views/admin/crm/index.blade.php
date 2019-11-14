@extends('admin.layouts.index')
@php $dataType = "show"; @endphp
@section('css')
  <link rel="stylesheet" type="text/css" href="{{asset('admin/css/delivery.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('admin/css/crm.css')}}">
@stop
@section('content_header')
    <h1><i class="fa fa-file-text-o"></i> {{trans('crm.CRM')}}</h1>
@stop
@section('content')
    @include('admin.crm._late_list_customer')
    @include('admin.crm._new_list_customer')
    @include('admin.crm._out_of_rice')
    @include('admin.crm._list_customer_no_order_3_months')
@stop
@include('admin.deliveries._form')
@php $dataType = "create"; @endphp
@include('admin.deliveries._form')
@section('javascript')
<script type="text/javascript" src="{{asset('admin/lang/delivery.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/delivery.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/crm.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lang/crm.js')}}"></script>
<script>
    var projects = <?php echo json_encode($projects); ?>;
    var products = <?php echo json_encode($products); ?>;
    var route_getInfoCustomer = <?php echo json_encode(route('admin.deliveries.getInfoCustomer')) ?>;
    var units = <?php echo json_encode($units) ?>;
    var promotion_products = <?php echo json_encode($promotion_products); ?>;
    var route_store = <?php echo json_encode(route('admin.deliveries.store')) ?>;
</script>
@stop