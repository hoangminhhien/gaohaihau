<div id="edit_building" class="modal fade">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <span id="building-modal-title">{{trans('building_room.building')}}</span>
        </div>
        <form class="form-horizontal" action="{{route('admin.building.edit_building')}}" method="POST">
            <div class="modal-body">
                <div class="container-fluid">
                  {{ csrf_field()}}
                  <div class="form-group">
                    <input type="hidden" id="id_building" class="form-control" name="id" value="">
                      <label class="col-sm-3 control-label">{{trans('building_room.project_code')}}</label>
                      <div class="col-sm-9">
                          <input type="hidden" id="projects_code_fake" class="form-control" name="project_code" value="">
                          <input type="text" id="projects_code" class="form-control" name="project_code" value="" disabled="">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">{{trans('building_room.building_code')}}</label>
                      <div class="col-sm-9">
                          <input type="hidden" id="buildings_code_fake" class="form-control" name="building_code" value="">
                          <input type="text" id="buildings_code" class="form-control" name="building_code" value="">
                      </div>
                  </div>
                   <div class="form-group">
                      <label class="col-sm-3 control-label">{{trans('building_room.name')}}</label>
                      <div class="col-sm-9">
                          <input type="text" id="building_name" class="form-control" name="building_name" value="">
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">{{trans('building_room.room_no')}}</label>
                      <div class="col-sm-9">
                          <select id="list_room" class="form-control select2" multiple="multiple" name="room_no[]" >
                          </select>
                      </div>
                      <input type="hidden" id="remaining_rice" class="form-control" name="remaining_rice" value="">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn_thuchien">{{trans('building_room.perform')}}</button>
            </div>
          </div>
        </form>
    </div>
</div>
