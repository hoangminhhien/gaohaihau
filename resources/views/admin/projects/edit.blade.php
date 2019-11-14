<div id="modal_edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title">{{trans('project.edit_project')}}</span>
            </div>
            <form action="" method="POST" class="form-horizontal" id="edit_submit_product">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit_id">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{{ trans('project.code')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="edit-project_code">
                            <div class="project_code-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">{{ trans('project.name')}}</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" id="edit_name">
                          <div class="name-errors"></div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('project.cancel_label')}}</button>
                      <button type="submit" class="btn btn-primary submit-button" id="btn_thuchien">{{trans('project.edit_submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>