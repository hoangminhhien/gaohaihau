@extends('admin.layouts.index')
@php $dataType = "show"; @endphp
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/delivery.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/customer.css')}}">
@stop
@section('content_header')
    @if(!empty($customers))
        @foreach($customers as $customer)
            <h1><i class="fa fa-user" aria-hidden="true"></i> {{$customer['id']}} - {{$customer['name']}}
        @endforeach
    @endif</h1>
@stop
@section('content')
<div class="product-container box">
    <div class="box-header with-border">
    <button class="btn btn-primary edit_customer" data-toggle="modal" data-target="#Modal_edit" data-customers="{{$customer}}"><i class="fa fa-pencil" aria-hidden="true"></i> {{trans('customer.show.edit_info_customer')}}
    </button>
        <h4>{{ trans('customer.show.product') }}</h4>
    </div>
    <div class="box-body">
        <div class="row">
            @if(empty($products))
                <div class="no_product">{{ trans('customer.show.no_product') }}</div>
            @endif
            @foreach($products as $product)
            <div class="product col-xs-2 col-sm-2 col-lg-2">
                <div id="row" style="position:relative;">
                    <div class="images">
                        <div class="image1" style="background-image: url({{asset($product->image_url)}}) ">
                        </div>
                    </div>
                        <div class="product-item-info">
                            <div class="product-item-name">
                                {{ $product->name }}
                                @if($product['gift_code'] == config('common.product.GIFT_CODE.NEWCUS.code'))
                                    <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                                @endif
                            </div>
                            <div class="product-item-capacity">
                                {{ trans('home.capacity') }}: {{ $product->capacity }} {{ trans('common.kg_unit') }}
                            </div>
                            <div class="product-item-price">
                                {{ CommonHelper::commonCurrency($product->price) }}
                            </div>
                            <div id="action">

                            </div>
                        </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h4>{{ trans('customer.show.order') }}</h4>
    </div>
    <div class="box-body">
        <table class="table table-bordered list_order table-striped delivered" >
            <thead>
                <tr>
                    <th style="width: 120px">{{ trans('delivery.list.code_order') }}</th>
                    <th class="name-customer-column">{{ trans('customer.show.status') }}</th>
                    <th class="quantity-column">{{ trans('delivery.list.quantity_cate') }}</th>
                    <th class="total-price-column">{{ trans('delivery.list.total_price') }}</th>
                    <th class="time-column">{{ trans('delivery.list.delivered_time') }}</th>
                    <th class="action-column"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderLists as $key => $order)
                    @php
                        $delivered_order_total = 0;
                    @endphp
                    <tr class="{{ $order->id }}">
                        <td class="text-center">{{ $order->id }}</td>
                        <td class="status-column">
                          <span class="label order-status-label-{{$order->status}}">
                            {{ trans('common.order_status_option.' . $order->status) }}
                          </span>
                        </td>
                        <td>
                            <ul>
                                @foreach($order['orderProduct'] as $key => $orderProuct)
                                    @if(empty($orderProuct['product'])) @continue @endif
                                    <?php  $price = $orderProuct->quantity*$orderProuct->price ;
                                        $delivered_order_total+=$price;
                                    ?>
                                    <li><span class="color-red" >{{ $orderProuct->quantity }}</span> x {{ $orderProuct['product']->name }} ({{ $orderProuct['product']->capacity }} {{trans('shipper.kg_unit')}})
                                        @if(CommonHelper::checkGiftCode($order, $orderProuct))                    
                                            <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-right">{{ CommonHelper::commonCurrency($delivered_order_total) }}</td>
                        <td>
                            @if(!empty($order->delivered_time ))
                                {{ date("Y/m/d H:i", strtotime($order->delivered_time)) }}</p>
                            @endif
                            @if(strtotime($order->delivered_time) > strtotime($order->delivery_time_expect_to))
                                <div class="label label-danger warn-late-delivery">{{ trans('order.warn_late_delivery') }}</div>
                            @endif
                        <td>
                            <button type="button" class="btn btn-default submit-button delivered-order-button" data-type="show" data-id= "{{ $order->id }}" data-href=" {{ route('admin.deliveries.show') }}">{{ trans('delivery.list.order_detail') }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $orderLists->appends(request()->input())->links()}}
        </div>
        <div class="box-footer clearfix">
        </div>
    </div>
</div>
@stop
@include('admin.customers.edit_customer')
@include('admin.deliveries._form')
@section('javascript')
    <script type="text/javascript" src="{{asset('admin/lang/delivery.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/delivery.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/customer.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/lang/customer.js')}}"></script>
    <script>
        var projects = <?php echo json_encode($projects); ?>;
        var products = <?php echo json_encode($product_list); ?>;
        var route_getInfoCustomer = <?php echo json_encode(route('admin.deliveries.getInfoCustomer')) ?>;
        var route_update = <?php echo json_encode(route('admin.customer.update_customer')) ?>;
        var units = <?php echo json_encode($units) ?>;
        var promotion_products = <?php echo json_encode($promotion_products); ?>;
    </script>
@stop