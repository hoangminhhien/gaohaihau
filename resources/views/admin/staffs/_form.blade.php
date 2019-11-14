<div class="modal fade" id="{{$dataType}}_modal-staff">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                @if($dataType == 'create')
                    <h4 class="modal-title">{{trans('staff.register_member')}}</h4>
                @elseif($dataType == 'edit')
                    <h4 class="modal-title">{{trans('staff.edit_member')}}</h4>
                @endif
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <input type="hidden"                               
                                    id="{{$dataType}}_id">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="col-sm-3 control-label common-star"> {{trans('staff.email')}} </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="{{$dataType}}_email"
                                            placeholder="Nhập email vào đây">
                                            <div class="email-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label common-star"> {{trans('staff.password')}} </label>
                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" id="{{$dataType}}_password" placeholder= "******" 
                                            @if($dataType == 'edit') disabled @endif>  
                                            <div class="password-errors"></div>
                                        </div>
                                        @if($dataType == 'edit')
                                            <div class="col-sm-5">
                                                <button type="button" id="Switch" class="btn btn-default switch turnON-turnOF">{{trans('staff.switch')}}</button>
                                            </div>
                                        @endif        
                                    </div>
                                        
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label common-star"> {{trans('staff.name')}} </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="{{$dataType}}_name" 
                                            placeholder="Nhập tên vào đây">
                                            <div class="name-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="role" class="col-sm-3 control-label common-star"> {{trans('staff.role')}} </label>
                                        <div class="col-sm-9 width_role">
                                            <select  class="form-control select2 role_select" 
                                                    id="{{$dataType}}_role">
                                                @foreach(config('common.role') as $value)
                                                    @if( Auth::user()['role'] >= $value)
                                                        <option value="{{$value}}"
                                                            >
                                                            {{ trans('staff.role_option.'.$value)}} 
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <center>
                            @if($dataType == 'create')
                                <button type="button" id="create_submit_Staff"
                                class="btn btn-info click-to-loading"><span class="fa fa-check"></span>
                                    {{trans('staff.register')}}
                                </button></center>
                            @elseif($dataType == 'edit')
                                <button type="button" id="edit_submit_Staff"
                                class="btn btn-info click-to-loading"><span class="fa fa-pencil-square-o"></span>
                                    {{trans('staff.edit')}}
                                </button>
                            @endif
                        </center>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>