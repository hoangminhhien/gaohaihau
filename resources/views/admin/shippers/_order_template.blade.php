@foreach($orders as $key => $order)
@php $total = 0; @endphp
<div class="acMenu" data-id="{{ $order['id'] }}">
    <div class="box-border-content external-event theme-bg ui-draggable ui-draggable-handle click-toggle fix-border-radius-0">
        <span>
            <span class="customer-name">{{ ucfirst($order['customer']->name) }} </span><br>
            <a class="fix-phone" href="tel:{{($order['customer']->phone)}}"> {{ CommonHelper::formatPhonenumber($order['customer']->phone) }} </a>
        <i class="fa fa-building" aria-hidden="true"></i>
        {{ ViewHelper::customerAddress($order['customer']) }} <br>
        <i class="fa fa-clock-o" aria-hidden="true"></i>
        @if(!empty($order->delivery_time_expect_from ))
            {{ date("H:i d/m/Y", strtotime($order->delivery_time_expect_from)) }}
        @endif
        ~
        @if(!empty($order->delivery_time_expect_to ))
            {{ date("H:i d/m/Y", strtotime($order->delivery_time_expect_to)) }}
        @endif
        </span>
        <i class="fa fa-angle-down fix-icon-center" aria-hidden="true"></i>
    </div>
    <div class="collapse shipper_detail">
        <div class="fix-select-float1">
            @foreach($order['orderProduct'] as $key => $orderProuct)
            <?php  $price = $orderProuct->quantity*$orderProuct->price ;
            $total+=$price;
            ?>
            <div>
                <li><span style="color: red">{{ $orderProuct->quantity }}</span> x {{ $orderProuct['product']->name }} ({{ $orderProuct['product']->capacity }} {{trans('shipper.kg_unit')}})</li>
            </div>
            @endforeach
            <div>
                <span class="price-fix">Tổng số tiền</span> : {{ CommonHelper::commonCurrency($total) }}
            </div>
        </div>
        <div class="fix-select-float2">
            <a class="btn btn-app add-button-delivery open-delivery-modal" data-href="{{ route('admin.shippers.delivery', $order['id']) }}">
            <i class="fa fa-inbox"></i> {{trans('shipper.delivery')}}
            </a>
        </div>
        <div class="clear-both"></div>
    </div>
</div>
@endforeach