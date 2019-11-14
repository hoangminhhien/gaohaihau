@php
    $currentPage = $order_list->currentPage();
    $no = ($currentPage - 1) * 5;
    $page_type = 'approve';
    if(request()->input('status') == config('common.order.status.ARCHIVED')) {
        $page_type = 'approved';
    }
@endphp
@extends('admin.layouts.index')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/order.css') }}">
@stop
@section('content_header')
    <h1><i class="fa fa-file-text-o"></i> {{ trans('order.' . $page_type . '_order_title') }}</h1>
@stop
@section('content')
<div class="box box-primary">
    <form class="form-horizontal" id="form_search">
        <input type="hidden" name="status" value="{{ old('status') }}">
        <div class="box-body">
            <div class="form-group">
                <label for="posted_date" class="col-sm-2 control-label">
                    {{trans('order.delivery_date')}}
                </label>
                <div class="col-sm-2">
                    <input type="text" class="form-control common-datepicker" name="delivered_time_from"
                        @if(!empty(old('delivered_time_from')))
                            value="{{ date('Y-m-d', strtotime(str_replace('/', '-', old('delivered_time_from')))) }}"
                        @endif
                    >
                </div>
                <label for="posted_date" class="col-sm-1 control-label text-center-i">~</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control common-datepicker" name="delivered_time_to"
                        @if(!empty(old('delivered_time_to')))
                            value="{{ date('Y-m-d', strtotime(str_replace('/', '-', old('delivered_time_to')))) }}"
                        @endif
                    >
                </div>
                <label for="posted_date" class="col-sm-2 control-label text-center-i">
                    {{ trans('order.order_limit') }}
                </label>
                <div class="col-sm-1">
                    <select class="form-control" name="limit">
                        @foreach (config('common.order.order_limit_selection') as $item)
                            <option value="{{ $item }}"
                                @if(old('limit') == $item) selected @endif
                            >{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="posted_date" class="col-sm-2 control-label">
                    {{trans('order.shipper')}}
                </label>
                <div class="col-sm-3">
                    <select class="form-control select2" name="shipper_id">
                        <option value="ALL" @if(old('shipper_id') == 'ALL') selected @endif>{{ trans('common.option_all') }}</option>
                        @foreach ($shipper_list as $item)
                            <option value="{{ $item['id'] }}"
                                @if(old('shipper_id') == $item['id']) selected @endif
                            >
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 d-flex-center">
                <button type="submit" class="btn btn-primary click-to-loading" id="search_blog"><span class="fa fa-search"></span> {{trans('staff.search')}} </button>
           </div>
        </div>
    </form>
</div>
<div class="box box-primary">
    <div class="box-body">
        <div class="row mb-20">
            <div class="col-sm-6">
                @if($page_type == 'approve')
                    <button type="button" class="btn btn-success submit-button" id="approve_order_button">{{ trans('order.approve_button') }}</button>
                @elseif($page_type == 'approved')
                    <button type="button" class="btn btn-danger submit-button" id="cancel_approve_order_button">{{ trans('order.cancel_approve_button') }}</button>
                @endif
            </div>
            <div class="col-sm-6 total-amount">
                <div class="label label-warning pull-right" id="total_amount">{{ CommonHelper::commonCurrency($total_amount) }}</div>
                <div class="text-info pull-right" id="total_amount_label">{{ trans('order.' . $page_type . '_total_amount') }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="check_all_order" class="control-label mr-10">
                    <input type="checkbox" name="check_all_order" id="check_all_order">
                    {{ trans('order.check_all_page') }}
                </label>
                <label for="check_all_current_page" class="control-label">
                    <input type="checkbox" id="check_all_current_page">
                    {{ trans('order.check_all_current_page') }}
                </label>
            </div>
        </div>
        <table class="table table-bordered list_order table-striped" >
            <tbody>
                <tr>
                    <th></th>
                    <th style="width: 10px">{{ trans('order.no') }}</th>
                    <th>{{ trans('order.name_customer') }}</th>
                    <th>{{ trans('order.phone') }}</th>
                    <th>{{ trans('order.quantity_cate') }}</th>
                    <th>{{ trans('order.shipper_name') }}</th>
                    <th>{{ trans('order.time') }}</th>
                    <th>{{ trans('order.total_price') }}</th>
                </tr>
                @foreach($order_list as $key => $order)
                @php
                    $total = 0;
                    $no++;
                @endphp
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="check_order" data-id="{{ $order['id'] }}">
                    </td>
                    <td class="text-center">{{ $no }}</td>
                    <td>
                        {{ $order['customer']->name }}<br>
                        <i class="fa fa-building" aria-hidden="true"></i>
                        {{ ViewHelper::customerAddress($order['customer']) }}
                    </td>
                    <td>{{ CommonHelper::formatPhonenumber($order['customer']->phone) }}</td>
                    <td>
                        <ul>
                            @foreach($order['orderProduct'] as $key => $orderProuct)
                                @php
                                    $price = $orderProuct->quantity * $orderProuct->price ;
                                    $total += $price;
                                @endphp
                                <li><span class="color-red" >{{ $orderProuct->quantity }}</span> x {{ $orderProuct['product']->name }} ({{ $orderProuct['product']->capacity }} {{trans('shipper.kg_unit')}})
                                    @if(CommonHelper::checkGiftCode($order, $orderProuct))
                                        <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @if(!empty($order['shipper']))
                            {{ $order['shipper']['name'] }}
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->delivered_time))
                            <div>{{ date("H:i d/m/Y", strtotime($order->delivered_time)) }}</div>
                            @if(strtotime($order->delivered_time) > strtotime($order->delivery_time_expect_to))
                                <div class="label label-danger warn-late-delivery">{{ trans('order.warn_late_delivery') }}</div>
                            @endif
                        @endif
                    </td>
                    <td class="common-currency">{{ CommonHelper::priceFormat($total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex-center">
            {{ $order_list->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@include('admin.partials.toastr')

{{-- Approve confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'approve_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('order.approve_confirm.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'approveConfirm',
])

{{-- Cancel confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'cancel_approve_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('order.cancel_approve_confirm.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'cancelApproveConfirm',
])
@endsection
@section('javascript')
    <script type="text/javascript">
        window.$approve_url = "{!! route('admin.orders.approve') !!}";
        window.$cancel_approve_url = "{!! route('admin.orders.cancel_approve') !!}";
    </script>
    <script type="text/javascript" src="{{ asset('admin/js/order.js') }}"></script>
@stop