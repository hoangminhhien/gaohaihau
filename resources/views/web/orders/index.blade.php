@extends('web.layouts.index')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/home.css') }}">
    <link rel="stylesheet" href="{{asset('web/css/order.css')}}">
@stop
@section('content')
    @include('web.home.header')
    <div class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <form class="form-horizontal" action="{{ route('orders.store') }}" method="POST" id="orderSubmitForm">
                        @csrf
                        <div class="col-md-12">
                            @include('web.orders._product_info')
                        </div>
                        <div class="col-md-7">
                            @include('web.orders._customer_info')
                        </div>
                        <div class="col-md-5 d-none-mobile">
                            <p class="thanks_you_title">{{trans('home.thanks_you_title')}}</p>
                            <img class="thanks_for_order" src="images/thanks_you.png">
                        </div>
                        <div class="col-md-2 col-md-offset-5">
                            <div class="but">
                                <button type="button" onclick="openSubmitOrderConfirmModal()" class="btn btn-success theme-btn-success submit-button submit-order-button">{{ trans('web_order.action_order') }}</button>
                                <a href="{{ route('home') }}" class="btn btn-default back-to-home-button d-none">{{ trans('web_order.back_to_home') }}</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- Confirm submit --}}
    @include('admin.partials.confirm', [
        'modal_id' => 'submit_order_confirm',
        'title' => trans('partials.modal.confirm_title'),
        'body' => trans('web_order.submit_order_modal.body'),
        'submit_label' => trans('partials.modal.ok'),
        'cancel_label' => trans('partials.modal.close'),
        'callback' => 'submitOrder',
    ])

    {{-- Alert success --}}
    @include('admin.partials.confirm', [
        'modal_id' => 'order_success',
        'title' => trans('web_order.order_success.title'),
        'body' => trans('web_order.order_success.body'),
        'submit_label' => trans('partials.modal.ok'),
        'is_hide_close' => true
    ])
    @include('web.partials.footer')
@stop
@section('javascript')
    <script src="{{asset('web/js/order.js')}}"></script>
    <script src="{{asset('lang/common.js')}}"></script>
    <script src="{{asset('lang/web_order.js')}}"></script>
    <script>
        var projects = <?php echo json_encode($projects); ?>;
        var promotion_products = <?php echo json_encode($promotion_products); ?>;
        var route_getInfoCustomer = <?php echo json_encode(route('web.orders.getInfoCustomer')) ?>;
</script>
@stop