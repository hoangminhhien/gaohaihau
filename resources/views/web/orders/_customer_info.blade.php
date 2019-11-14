<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12 customer-info-title">
                <b>{{ trans('web_order.your_info') }}</b>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="number_kh" class="col-sm-2 control-label">{{ trans('web_order.phone') }}</label>
                    <div class="col-sm-10 phone">
                        <input class="form-control number_kh common-number" name="phone" autocomplete="new-password">
                        <div class="phone-info"></div>
                        <div class="phone-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name_kh" class="col-sm-2 control-label">{{ trans('web_order.name') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control name_kh" name="name">
                        <input type="hidden" name="customer_id" class="form-control customer_id">
                        <div class="name-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="address_kh" class="col-sm-2 control-label">{{ trans('delivery.create.address') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control address_kh" name="address_kh">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name_kh" class="col-sm-2 control-label">{{ trans('delivery.create.time') }}</label>
                    <div class="col-sm-10">
                        <div class="col-sm-5 p-0">
                            <input block-hour="0,1,2,3,4,5,6" open_drop="up" minute_step="15" name="delivery_time_expect_from" min_date="{{ date('Y-m-d') }}" class="form-control common-datepicker delivery_time time_from"  time="true" time_24h="true" format="YYYY-MM-DD HH:mm">
                            <div class="delivery_time_expect_from-errors"></div>
                        </div>
                        <label for="number_kh" class="col-sm-2 control-label text-center-i to-character d-none-mobile">
                            ~
                        </label>
                        <div class="d-none-desktop mtb-10">{{ trans('web_order.date_to') }}</div>
                        <div class="col-sm-5 p-0">
                            <input block-hour="0,1,2,3,4,5,6" minute_step="15" open_drop="up" name="delivery_time_expect_to" min_date="{{ date('Y-m-d') }}" class="form-control common-datepicker delivery_time time_to" time="true" time_24h="true" format="YYYY-MM-DD HH:mm">
                            <div class="delivery_time_expect_to-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>