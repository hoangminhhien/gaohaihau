<div id="Modal_edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">
                    {{trans('customer.edit_info')}}
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="edit_submit_customer">
                    <div class="container-fluid">
                        <div class="row">
                            <input type="hidden" id="edit_id" class="form-control">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{trans('customer.name')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="edit_name" class="form-control" name="name" >
                                        <div class="name-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label ">{{trans('customer.phone')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="edit_phone" class="form-control" name="phone" >
                                        <div class="phone-errors"></div>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="da_kh" class="col-sm-2 control-label">{{ trans('delivery.create.project') }}</label>
                                    <div class="col-sm-10">
                                        <select  class="form-control select2 project_list" name="project_code" data-building="" name="project" id="edit-project">
                                        </select>
                                        <div class="project_code-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name_kh" class="col-sm-4 control-label">{{ trans('delivery.create.building') }}</label>
                                    <div class="col-sm-8">
                                        <select  class="form-control select2 building" name="building_code" id="edit-building">
                                        </select>
                                        <div class="building_code-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">{{ trans('delivery.create.room') }}</label>
                                    <div class="col-sm-9">
                                        <select  class="select2 form-control room" name="room_no"  id="edit-room">
                                        </select>
                                        <div class="room_no-errors"></div>
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
                                    <label class="col-sm-4 control-label">{{ trans('customer.family_number_of_adults') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control common-numeric" id="family_number_of_adults">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ trans('customer.family_number_of_children') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control common-numeric" id="family_number_of_children">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ trans('customer.remaining_rice') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="remaining_rice" class="form-control common-numeric">
                                            <span class="input-group-addon">
                                                {{ trans('shipper.kg_unit') }}
                                            </span>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="box-footer">
                        <center>
                            <button type="submit" class="btn btn-primary submit-button" id="btn_perform">{{trans('product.ok')}}
                            </button>
                        </center>    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>