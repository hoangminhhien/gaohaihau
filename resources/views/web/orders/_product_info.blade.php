<div class="table-responsive">
    <div class="product_screen_computer">
        <table class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th class="product-col">{{ trans('web_order.product') }}</th>
                    <th class="price-col">{{ trans('web_order.price') }}</th>
                    <th class="quantity-col">{{ trans('web_order.quantity') }}</th>
                    <th class="total-price-col">{{ trans('web_order.total_price') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_products as $key => $product)
                    <tr order-product product_id="{{ $product['id'] }}">
                        <td>
                            <div class="product-image">
                                @if(!empty($product['image_url']))
                                    <img src="{{$product['image_url']}}" width="50px" height="50px">
                                @endif
                            </div>
                            <div class="product-name">
                                {{ $product['name'] }} ({{ $product['capacity'] }} {{ trans('common.kg_unit') }})
                            </div>
                        </td>
                        <td class="text-right" rname="price" value="{{ $product['price'] }}">
                           {{ CommonHelper::commonCurrency($product['price']) }}
                        </td>
                        <td class="text-center change-quantity">
                            <input class="form-control quantity common-numeric" rname="quantity" value="{{ $product['quantity'] }}">
                            <button type="button" class="btn btn-default quantity-plus"><i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default quantity-minus"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-danger quantity-clear"><i class="fa fa-times"></i></button>
                        </td>
                        <td class="text-right" rname="total-price" value="{{ $product['price'] * $product['quantity'] }}">
                           {{ CommonHelper::commonCurrency($product['price'] * $product['quantity']) }}
                        </td>
                    </tr>
                @endforeach
                <tr class="text-right total-order-price">
                <td colspan="3">{{ trans('web_order.total_order_price') }}</td>
                <td>
                    <span rname="total-order-price"></span>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="product_screen_mobile">
        <table class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th class="product-col">{{ trans('web_order.product') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_products as $key => $product)
                    <tr order-product product_id="{{ $product['id'] }}">
                        <td>
                            <div>
                                <div class="product-image">
                                    @if(!empty($product['image_url']))
                                        <img src="{{$product['image_url']}}" width="50px" height="50px">
                                    @endif
                                </div>
                                <div class="product-name">
                                    {{ $product['name'] }} ({{ $product['capacity'] }} {{ trans('common.kg_unit') }})
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="pull-left">{{ trans('web_order.price') }}</div>
                                <div class="text-right pull-right" rname="price" value="{{ $product['price'] }}">
                                   {{ CommonHelper::commonCurrency($product['price']) }}
                                </div>
                            <div class="clear"></div>
                            </div>
                            <div class="mb-10">
                                <div class="pull-left">
                                    {{ trans('web_order.quantity') }}
                                </div>
                                <div class="text-right change-quantity pull-right">
                                    <button type="button" class="btn btn-default quantity-plus"><i class="fa fa-plus"></i></button>
                                    <input class="form-control quantity common-numeric" rname="quantity" value="{{ $product['quantity'] }}">
                                    <button type="button" class="btn btn-default quantity-minus"><i class="fa fa-minus"></i></button>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="mb-10">
                                <div class="pull-left">
                                    {{ trans('web_order.total_price') }}
                                </div>
                                <div class="text-right pull-right" rname="total-price" value="{{ $product['price'] * $product['quantity'] }}">
                                   {{ CommonHelper::commonCurrency($product['price'] * $product['quantity']) }}
                                </div>
                                <div class="clear"></div>
                            </div>
                            <a href="javascript:void(0)" class="text-red quantity-clear">
                                <i class="fa fa-times"></i>
                                {{ trans('web_order.delete_product') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr class="text-right total-order-price">
                <td>
                    <div class="pull-left">
                        {{ trans('web_order.total_order_price') }}
                    </div>
                    <div class="pull-right" rname="total-order-price"></div>
                    <div class="clear"></div>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-4 col-md-9">
        <div class="button-option-cart">
            <a href="{{ route('home') }}" class="select_product"><span class="fa fa-reply"></span> {{ trans('web_order.select_product') }}</a>
            <a href="javascript:void(0);" class="delete_all_product" onclick="openDeleteAllProductConfirmModal();"><span class="fas fa-trash-alt"></span> {{ trans('web_order.delete_all') }}</a>
        </div>
    </div>
</div>
{{-- Delete all product confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'delete_all_product_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('web_order.delete_all_product_confirm.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'deleteAllProductConfirm',
])