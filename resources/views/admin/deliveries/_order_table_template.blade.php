@php
    $delivered_order_total = 0;
@endphp
<tr class="{{ $order->id }} show-order-detail">
    <td class="text-center">{{ $order->id }}</td>
    @if (!empty($order['customer']))
        <td class="width-table-name">
                <a class="decoration-hover" onclick="event.stopPropagation();" href="{{route('admin.customer.show', $order['customer']->id)}}">{{ $order['customer']->name }}
                </a><br>
            <i class="fa fa-building" aria-hidden="true"></i>
            {{ ViewHelper::customerAddress($order['customer']) }}
        </td>
        <td>{{ CommonHelper::formatPhonenumber($order['customer']->phone) }}</td>
    @else
        <td></td><td></td>
    @endif
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
        <button type="button" class="btn btn-primary submit-button mb-10 approve_order_button" data-id= "{{ $order->id }}" data-href=" {{ route('admin.deliveries.approve') }}" >{{ trans('delivery.list.approve_button') }}</button>
        <button type="button" class="btn btn-default submit-button delivered-order-button show-delivered d-none" data-type="show" data-id= "{{ $order->id }}" data-href=" {{ route('admin.deliveries.show') }}">{{ trans('delivery.list.order_detail') }}</button>
    </td>
</tr>