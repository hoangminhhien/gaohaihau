<div id="modal_add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span>{{ trans('project.create')}}</span>
            </div>
            <form action="" method="POST" id="create_submit_product" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit_id">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{{ trans('project.code')}}</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="project_code" name="project_code">
                          <div class="project_code-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">{{ trans('project.name')}}</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="name1" name="name">
                        <div class="name-errors"></div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('project.cancel_label')}}</button>
                    <button type="submit" class="btn btn-primary submit-button">{{trans('project.create_submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>