<link rel="stylesheet" type="text/css" href="{{asset('admin/css/product.css')}}">
<div class="modal fade" id="{{$dataType}}_modal-categories">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                @if($dataType == 'create')
                    <h4 class="modal-title">{{trans('categories.create_category')}}</h4>
                @elseif($dataType == 'edit')
                    <h4 class="modal-title">{{trans('categories.edit_category')}}</h4>
                @endif
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <input type="hidden" id="{{$dataType}}_id">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label common-star"> {{trans('categories.name')}} </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="{{$dataType}}_name"
                                            placeholder= "{{trans('categories.input_name')}}">
                                            <div class="name-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="slug" class="col-sm-3 control-label common-star"> {{trans('categories.slug')}} </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="{{$dataType}}_slug" 
                                            placeholder="{{trans('categories.input_slug')}}">
                                            <div class="slug-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="parent_category" class="col-sm-3 control-label"> {{trans('categories.parent_category')}} </label>
                                        <div class="col-sm-9 width_parent_category">
                                            <select  class="form-control select2 parent_category_select" 
                                                    id="{{$dataType}}_parent_category">
                                                <option value="default">
                                                    {{trans('categories.default')}}
                                                </option>
                                                @foreach($categoryLists as $categoryList)
                                                        <option value="{{$categoryList->id}}"
                                                            >
                                                            {{$categoryList->name}}
                                                        </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-3 control-label">{{trans('product.public')}}</label>
                                    <div class="col-sm-9">
                                        <label class="switch">
                                            <input type="checkbox" id="{{$dataType}}_is_public" name="is_public" value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <center>
                            @if($dataType == 'create')
                                <button type="button" id="create_submit_categories"
                                class="btn btn-info click-to-loading"><span class="fa fa-check"></span>
                                    {{trans('categories.create')}}
                                </button></center>
                            @elseif($dataType == 'edit')
                                <button type="button" id="edit_submit_categories"
                                class="btn btn-info click-to-loading"><span class="fa fa-pencil-square-o"></span>
                                    {{trans('categories.edit')}}
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