<div class="modal fade" id="modal-cacel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <b>{{ trans('partials.modal.confirm_title') }}</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" style="margin-bottom: 0px">
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name_kh" class="col-sm-2 control-label">{{ trans('delivery.modal.reason') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Nhập lý do" name="canceled_note">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn btn-secondary" data-dismiss="modal">
                            {{ trans('partials.modal.close') }}
                        </a>
                        <button type="button" class="btn btn-danger modal-cacel">
                            {{ trans('partials.modal.ok') }}
                        </button>
                      </div>
                        <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>