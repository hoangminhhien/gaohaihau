@foreach($total_products as $total_product )
    <li class="stock">
        <span class="quantity-stock">{{$total_product['quantity']}}</span> {{$total_product['name']}} ({{$total_product['capacity']}} {{trans('shipper.kg_unit')}})
    </li>
@endforeach