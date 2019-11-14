<div class="modal fade delivery-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="deliveryForm">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="close-modal">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="delivery-modal-capture-box text-info" id="open_camera">
                                <i class="fa fa-close remove-image d-none"></i>
                                <span class="open-camera-text">
                                    {{ trans('shipper.capture_box') }}
                                </span>
                            </div>
                            <input type="file" name="delivery_image_url" accept="image/*;capture=camera" class="d-none-i">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-7">
                            {{ trans('shipper.remaining_rice') }} <br>
                            ({{ trans('shipper.before_ship') }})
                        </div>
                        <div class="col-xs-5">
                            <div class="input-group">
                                <input name="remaining_rice_before_ship" class="form-control common-numeric">
                                <span class="input-group-addon">
                                    {{ trans('shipper.kg_unit') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="delivery_image_url-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex-center">
                    <button type="submit" class="btn btn-primary submit-button">
                        <i class="fa fa-check"></i>
                        {{ trans('shipper.delivery_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>