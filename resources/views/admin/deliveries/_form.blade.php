<div class="modal fade" id="{{$dataType}}_modal-delivery">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if($dataType == 'create')
                    <b>{{ trans('delivery.edit.header') }}</b>
                @endif
                @if($dataType == 'edit')
                    <b>{{ trans('delivery.edit.header') }}</b>
                @endif
                @if($dataType == 'show')
                    <b>{{ trans('delivery.show.header') }}</b>
                @endif
                @if($dataType == 'delivery')
                    <b>{{ trans('delivery.delivery.header') }}</b>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="{{$dataType}}_delivery">
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name_kh" class="col-sm-4 control-label">{{ trans('delivery.create.name_customer') }}</label>
                                        <div class="col-sm-8 phone">
                                            <input type="text" class="form-control name_kh info_kh" placeholder="" name="name">
                                            <input type="hidden" name="customer_id" class="form-control customer_id">
                                            <input type="hidden" name="issue_id" class="form-control issue_id">
                                            @if($dataType == 'edit' || $dataType == 'show' || $dataType == 'delivery' )
                                                <input type="hidden" name="order_id" class="form-control order_id">
                                                <div class="productId"></div>
                                            @endif
                                            <div class="phone-info"></div>
                                            <div id="{{$dataType}}_name-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="number_kh" class="col-sm-3 control-label">{{ trans('delivery.create.phone') }}</label>
                                        <div class="col-sm-9 phone">
                                            <input class="form-control number_kh info_kh" placeholder="" name="phone" autocomplete="new-password">
                                            <div class="phone-info"></div>
                                            <div id="{{$dataType}}_phone-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="da_kh" class="col-sm-2 control-label">{{ trans('delivery.create.project') }}</label>
                                        <div class="col-sm-10">
                                            <select  class="form-control select2 project_list" name="project_code" data-building="" name="project">
                                            </select>
                                            <div id="{{$dataType}}_project_code-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name_kh" class="col-sm-4 control-label">{{ trans('delivery.create.building') }}</label>
                                        <div class="col-sm-8">
                                            <select  class="form-control select2 building" name="building_code">
                                            </select>
                                            <div id="{{$dataType}}_building_code-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="number_kh" class="col-sm-3 control-label">{{ trans('delivery.create.room') }}</label>
                                        <div class="col-sm-9">
                                            <select  class="select2 form-control room" name="room_no" >
                                            </select>
                                            <div id="{{$dataType}}_room_no-errors"></div>
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">
                                            {{ trans('delivery.create.number_of_adult') }}
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control common-numeric family_number_of_adults" name="family_number_of_adults">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">
                                            {{ trans('delivery.create.number_of_children') }}
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control common-numeric family_number_of_children" name="family_number_of_children">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{ trans('delivery.create.product') }}</label>
                                        <div class="col-sm-8">
                                            <select  class="form-control select2 list_sp" >
                                                @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}} ({{$product->capacity}} kg)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3" style="text-align: center; padding-top: 6px;">x</label>
                                        <div class="col-sm-9">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control list_sl" name="import_quantity">
                                            </div>
                                            <div class="col-sm-4 unit" style="padding-top: 6px" >
                                            </div>
                                            <div class="col-sm-2">
                                                <a class="btn btn-primary bt_add"><i class="fa fa-plus-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8 col-sm-offset-1 showsp" >
                                            
                                        </div>
                                        <div class="col-sm-8 col-sm-offset-3" >
                                            <div id="{{$dataType}}_product_id-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name_kh" class="col-sm-4 control-label">{{ trans('delivery.create.time') }}</label>
                                        <div class="col-sm-8">
                                            <input type="" block-hour="0,1,2,3,4,5,6" open_drop="up" minute_step="15" name="delivery_time_expect_from" min_date="{{ date('Y-m-d') }}" class="form-control common-datepicker delivery_time time_from"  time="true" time_24h="true" format="YYYY-MM-DD HH:mm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="number_kh" class="col-sm-2 control-label text-center-i">~</label>
                                        <div class="col-sm-10">
                                            <input type="" block-hour="0,1,2,3,4,5,6" minute_step="15" open_drop="up" name="delivery_time_expect_to" min_date="{{ date('Y-m-d') }}" class="form-control common-datepicker delivery_time time_to" time="true" time_24h="true" format="YYYY-MM-DD HH:mm">
                                            <div id="{{$dataType}}_delivery_time_expect_to-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                @if($dataType == 'show')
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="number_kh" class="col-sm-2 control-label">{{ trans('delivery.show.delivered_time') }}</label>
                                        <div class="col-sm-4">
                                            <input open_drop="up" name="delivered_time" class="form-control common-datepicker delivered_time" format="YYYY-MM-DD HH:mm">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="da_kh" class="col-sm-4 control-label">{{ trans('delivery.create.shipper') }}</label>
                                        <div class="col-sm-8">
                                            <select  class="form-control select2 shipper_id" name="shipper_id" >
                                                <option value="">
                                                    {{ trans('delivery.create.not_select') }}
                                                </option>
                                                @foreach($shipper_list as $shipper)
                                                    <option value="{{$shipper->id}}">{{$shipper->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-xs-6 control-label pt-0-i">
                                            {{ trans('shipper.remaining_rice') }} <br>
                                            ({{ trans('shipper.before_ship') }})
                                        </label>
                                        <div class="col-xs-6">
                                            <div class="input-group">
                                                <input name="remaining_rice" class="form-control common-numeric remaining_rice">
                                                <span class="input-group-addon">
                                                    {{ trans('shipper.kg_unit') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($dataType == 'create')
                            <center><button type="button" class="btn btn-info" id="create_submit">{{ trans('delivery.create.order') }}</button></center>
                        @endif
                        @if($dataType == 'edit')
                            <center><button type="button" class="btn btn-info" id="edit_submit">{{ trans('delivery.edit.order') }}</button></center>
                        @endif
                        @if($dataType == 'delivery')
                            <center><button type="button" class="btn btn-info" id="delivery_submit">{{ trans('delivery.delivery.delivery') }}</button></center>
                        @endif
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@include('admin.partials.confirm', [
    'modal_id' => 'approve_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('order.approve_confirm.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'approveConfirm',
])