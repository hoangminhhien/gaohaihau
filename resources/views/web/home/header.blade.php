<section id="header">
    <div class="navbar-fixed-top background-nav">
      <div class="container">
        <div class="navbar-header color-text">
            <ul class="nav navbar-nav navbar-right center-nav-right">
                <li class="background-icon">
                    <span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                    <span>
                        <a href={{ route('web.orders') }}>{{trans('home.shop_card')}} (<span id="items-count"></span>)
                            <div class="add-to-cart-success" id="add-to-cart-success" style="display: none;">
                                <span class="close" id="add-to-cart-success-modal-close"><i class="far fa-times-circle"></i></span>
                                <p class="text">
                                    <i class="fas fa-check-circle"></i>
                                    {{trans('home.add_to_cart_success')}}
                                </p>
                                <a class="btn button" href={{ route('web.orders') }}>{{trans('home.go_to_order_page')}}</a>
                            </div>
                        </a>
                    </span>
                </li>
            </ul>
            <a style="font-size:24px;text-transform: uppercase;" class="navbar-brand" href={{ route('home') }}>{{trans('home.name_product')}}</a>
            <div class="navbar-brand info-text" style="font-size:20px;color:white;">
                Đặt hàng:
                <a href="tel:{{ config('common.footer_info.hotline') }}" style="color:white;">
                    {{ CommonHelper::formatPhonenumber(config('common.footer_info.hotline')) }}
                </a> -
                <a href="tel:{{ config('common.footer_info.hotline_fedback') }}" style="color:white;">
                    {{ CommonHelper::formatPhonenumber(config('common.footer_info.hotline_fedback')) }}
                </a>
            </div>

        </div>
      </div>
    </div>
    <div class="background-header">
    </div>
    <div class="select-1">
        <div class="container-select">
            <div class="row">
                <div class="col-xs-12 col-sm-6 section-1-left">
                    <div class="section-1-left-image"></div>
                    <div class="section-1-left-description">
                        <div class="font-50 title-1">{{trans('home.freeship')}}</div>
                        <div class="section-1-description">{{trans('home.free_rice_delivery')}}</div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="section-1-right-image section-1-right"></div>
                    <div class="section-1-right-description">
                        <div class="font-50 title-1">{{trans('home.give_rice')}}</div>
                        <div class="section-1-description">{{trans('home.free_10kg_rice_barrels_for_new_customers')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
