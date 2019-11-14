<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div id="product_list">
                @foreach ($category_list as $element)
                    @if(!empty($element['products']->count()))
                        <div class="category-group">
                            <div class="category-name">
                                <span>{{ $element['name'] }}</span>
                            </div>
                            @foreach ($element['products'] as $item)
                                <div class="product-item">
                                    @if($item->type !== config('common.product.type.supplies'))
                                        <div class="product-item-type"
                                            style="
                                                background: url('{{ asset("images/categories/" . $item->type . ".png") }}');
                                                background-size: contain;
                                                background-position: center;
                                                background-repeat: no-repeat;
                                            "
                                        ></div>
                                    @endif
                                    <div class="product-item-image-contain">
                                        <div class="product-item-image"
                                        @if(!empty($item->image_url))
                                            style="
                                                background: url('{{ asset($item->image_url) }}');
                                                background-size: contain;
                                                background-position: center;
                                                background-repeat: no-repeat;
                                            "
                                        @endif
                                        ></div>
                                    </div>
                                    <div class="product-item-info">
                                        <div class="product-item-name">
                                            {{ $item->name }}
                                        </div>
                                        <div class="product-item-capacity">
                                            {{ trans('home.capacity') }}: {{ $item->capacity }} {{ trans('common.kg_unit') }}
                                        </div>
                                        <div class="product-item-made-from">
                                            {{ trans('home.made_from') }}: {{ $item->made_from }}
                                        </div>
                                        <div class="product-item-desc" data-toggle="tooltip" data-html="true"
                                        @if(!empty($item->desc))
                                            title="<div class='font-times-new-roman break-line'>{{ CommonHelper::keepXLines($item->desc) }}<div>"
                                        @else
                                            title="<div class='font-times-new-roman break-line'>{{ CommonHelper::keepXLines($item->short_desc) }}<div>"
                                        @endif>{{ CommonHelper::keepXLines(str_limit($item->short_desc, 200, '...')) }}</div>
                                        <div class="product-item-price">
                                            {{ CommonHelper::commonCurrency($item->price) }}
                                        </div>
                                        <div class="product-item-cart">
                                            <button type="button" class="btn btn-success add-to-card-btn" data-id={{$item->id}} data-quantity=1>
                                                <i class="fa fa-shopping-cart"></i>
                                                {{ trans('home.add_to_cart') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    <div class="clear"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
