@extends('admin.layouts.index')
@section('css')
<link href="{{asset('libs/select2/select2.min.css')}}" rel="stylesheet"/>
<link rel="stylesheet" href="{{asset('admin/css/delivery.css')}}">
@stop
@section('content')
<?php 
    $currentPage = $orders->currentPage();
    $currentPage_customer = $customer_orders->currentPage();
    $currentPage_delivered = $delivered_orders->currentPage();
?>
<div class="box">
    <div class="box-header with-border ready_delivery">
        <p>{{ trans('delivery.list.approve_order') }}</p>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered browse_oder table-striped list_order" >
            <thead>
                <tr>
                    <th style="width: 120px">{{ trans('delivery.list.code_order') }}</th>
                    <th style="width: 180px">{{ trans('delivery.list.name_customer') }}</th>
                    <th style="width: 170px">{{ trans('delivery.list.phone') }}</th>
                    <th style="width: 420px">{{ trans('delivery.list.quantity_cate') }}</th>
                    <th style="width: 160px">{{ trans('delivery.list.total_price') }}</th>
                    <th style="width: 270px">{{ trans('delivery.list.time') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer_orders as $key => $order)
                    @include('admin.deliveries._customer_order_template')
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $customer_orders->appends(['o2' => $orders->currentPage(), 'o1' => $customer_orders->currentPage()], request()->input())->links()}}
            <!-- {{ $orders->appends(request()->input())->links() }} -->
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
    </div>
</div>
<div class="box">
    <div class="box-header with-border ready_delivery">
        <p>{{ trans('delivery.list.ready_to_ship') }}</p>
        <button type="button" class="btn btn-success add_order_delivery" data-type="create" >{{ trans('delivery.list.add') }}</button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered ready_order table-striped list_order" >
            <thead>
                <tr>
                    <th style="width: 120px">{{ trans('delivery.list.code_order') }}</th>
                    <th style="width: 180px">{{ trans('delivery.list.name_customer') }}</th>
                    <th style="width: 170px">{{ trans('delivery.list.phone') }}</th>
                    <th style="width: 420px">{{ trans('delivery.list.quantity_cate') }}</th>
                    <th style="width: 160px">{{ trans('delivery.list.total_price') }}</th>
                    <th style="width: 270px">{{ trans('delivery.list.time') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $key => $order)
                    @include('admin.deliveries._confirm_order_template')
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $orders->appends(['o2' => $orders->currentPage(), 'o1' => $customer_orders->currentPage()], request()->input())->links()}}
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
    </div>
</div>
{{-- Delivered table --}}
@include('admin.deliveries._delivered_table')
@endsection
@include('admin.deliveries.create')
@include('admin.deliveries.edit')
@include('admin.deliveries.show')
@include('admin.deliveries.delivery')
@include('admin.deliveries.modal_cacel')
@section('javascript')
<script type="text/javascript" src="{{asset('libs/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/lang/delivery.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/delivery.js')}}"></script>
<script>
    var projects = <?php echo json_encode($projects); ?>;
    var products = <?php echo json_encode($products); ?>;
    var route_store = <?php echo json_encode(route('admin.deliveries.store')) ?>;
    var update_route = <?php echo json_encode(route('admin.deliveries.update',['status' => 2])) ?>;
    var delivery_route = {!! json_encode(route('admin.deliveries.update',['status' => config('common.order.status.DELIVERED')])) !!};
    var route_getInfoCustomer = <?php echo json_encode(route('admin.deliveries.getInfoCustomer')) ?>;
    var units = <?php echo json_encode($units) ?>;
    var promotion_products = <?php echo json_encode($promotion_products); ?>;
</script>
@stop