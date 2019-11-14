<ul class="control-sidebar-menu amount-stock">
    <div class="amount-stock-title">{{trans('shipper.delivery_exist')}}</div>
    <div id="remaining_total_view">
        @foreach($total_products as $total_product )
        <li class="stock">
            <span class="quantity-stock">{{$total_product['quantity']}}</span> {{$total_product['name']}} ({{$total_product['capacity']}} {{trans('shipper.kg_unit')}})
        </li>
        @endforeach
    </div>
</ul>
<div class="common-stock" id="order_view">
    @foreach($orders as $key => $order)
    <?php $total = 0;?>
    <div class="acMenu" data-id="{{ $order['id'] }}">
        <div class="box-border-content external-event theme-bg ui-draggable ui-draggable-handle click-toggle fix-border-radius-0">
            <span>
                <span class="customer-name">{{ ucfirst($order['customer']->name) }} </span><br>
                <a class="fix-phone" href="tel:{{($order['customer']->phone)}}"> {{ CommonHelper::formatPhonenumber($order['customer']->phone) }} </a>
            <i class="fa fa-building" aria-hidden="true"></i>
           @if(!empty($order['customer']['building_code']) && !empty( $order['customer']['room_no']))
            <td class="text-center">
                {{ ViewHelper::customerAddress($order['customer']) }}
            </td>
            @else
                <td class="text-center">{{ $order['customer']->address }}
                </td>
            @endif <br>
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
                <li><span class="color-red" >{{ $orderProuct->quantity }}</span> x {{ $orderProuct['product']->name }} ({{ $orderProuct['product']->capacity }} {{trans('shipper.kg_unit')}})
                    @if(CommonHelper::checkGiftCode($order, $orderProuct))                    
                        <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                    @endif
                </li>
                @endforeach
                <div>
                    <span class="price-fix">{{trans('shipper.total_amount')}}</span> : {{ CommonHelper::commonCurrency($total) }}
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
</div>