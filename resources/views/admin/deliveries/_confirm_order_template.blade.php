<?php $total = 0; ?>
<tr class="{{ $order->id }} show-order-detail">
    <td class="text-center">{{ $order->id }}</td>
    @if(!empty($order['customer']))
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
                <?php
                    $price = $price = $orderProuct['quantity']*$orderProuct['price'];
                    $total+=$price;
                ?>
                <li><span class="color-red" >{{ $orderProuct->quantity }}</span> x {{ $orderProuct['product']->name }} ({{ $orderProuct['product']->capacity }} {{trans('shipper.kg_unit')}})
                    @if(CommonHelper::checkGiftCode($order, $orderProuct))
                        <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </td>
    <td class="text-right">{{ CommonHelper::priceFormat($total) }} đ</td>
    <td>
        @if(!empty($order->delivery_time_expect_from ))
            <p>{{ trans('delivery.list.from') }}: {{ date("Y/m/d H:i", strtotime($order->delivery_time_expect_from)) }}</p>
        @endif
        @if(!empty($order->delivery_time_expect_to ))
            <p>{{ trans('delivery.list.to') }}: {{ date("Y/m/d H:i", strtotime($order->delivery_time_expect_to)) }}</p>
        @endif
    <td>
        <div class="delivered-delete"><button class="btn btn-danger delete-order" data-order_id= "{{ $order->id }}" data-href=" {{ route('admin.deliveries.cancel',['status' => 0]) }} ">{{ trans('delivery.list.cacel') }}</button></div>
        <div><button type="button" class="btn btn-default submit-button delivered-order-button hide-delivered d-none" data-type="show" data-id= "{{ $order->id }}" data-href=" {{ route('admin.deliveries.show') }}">{{ trans('delivery.list.order_detail') }}</button></div>
        <div>
            <button type="button" class="btn btn-warning submit-button confirm-order" data-type="delivery" data-id= "{{ $order->id }}" data-href=" {{ route('admin.deliveries.edit') }}">
                {{ trans('delivery.list.delivery') }}
            </button>
        </div>
    </td>
</tr>