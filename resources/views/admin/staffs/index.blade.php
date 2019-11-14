@extends('admin.layouts.index')
@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/css/staff.css')}}">
@stop
<section class="content">
  <div class="row row-background">
        <div class="box box-primary">
            <form class="form-horizontal" id="form_search" name="form-search" action="" method="get">
                <div class="box-body">
                    <div class="form-group">
                        <label for="posted_date" class="col-sm-2 control-label">{{trans('staff.name')}}</label>
                        <div class="col-sm-10">
                            <div class="col-xs-4">
                                <input name="name" class= "form-control" value="{{old('name')}}">
                            </div>
                            <div class="col-xs-2">
                                <label class="col-xs-12 control-label" style="text-align: center;">{{trans('staff.role')}}</label>
                            </div>
                            <div class="col-xs-4">                   
                                <select class="form-control" name="role">
                                    <option value="ALL"
                                    @if(old('role') == "ALL") selected @endif
                                    >
                                    {{trans('staff.role_option.all')}}
                                    </option>
                                    @foreach(config('common.role') as $value)
                                    <option value="{{$value}}"
                                    @if(old('role') == $value) selected @endif
                                    >
                                    {{ trans('staff.role_option.'.$value)}} 
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">{{trans('staff.email')}}</label>
                        <div class="col-sm-10">
                            <div class="col-xs-4">
                                <input class="form-control" type="text" name="email" value="{{old('email')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary pull-right click-to-loading center-search" id="search_blog"><span class="fa fa-search"></span>{{trans('staff.search')}} </button>
                   </div>          
                </div>
            </form>
        </div>
    <div class="col-xs-2 button-register">
        <button class="btn btn-success btn-sm commmon-button" data-toggle="modal" data-target="#create_modal-staff" id="open"><span class="fa fa-user-plus"></span> {{trans('staff.register_member')}}</button>
    </div>
    <div class="col-md-4" style="float: right;">
        <div class="pull-right">
            {{ $staffLists->appends(request()->input())->links() }}
        </div>
    </div> 
    <div class="form-group">
        <div class="col-sm-12">
            <table class="table table-bordered commmon-table table-striped">
                <thead>
                    <th class="text-center">{{trans('staff.No')}}</th>
                    <th class="text-center">{{trans('staff.register_day')}}</th>
                    <th class="text-center">{{trans('staff.name')}}</th>
                    <th class="text-center">{{trans('staff.email')}}</th>
                    <th class="text-center">{{trans('staff.role')}}</th>
                    <th></th>
                </thead>
            <tbody>             
            @foreach($staffLists as $key => $staffList)
                <tr>
                    <td class="text-center">
                        {{$staffList->id}}
                    </td>
                    <td class="text-center">
                        {{date("d/m/Y", strtotime($staffList->created_at))}}
                    </td>
                    <td>
                        {{$staffList->name}}
                    </td>
                    <td>
                        {{$staffList->email}}
                    </td>
                    <td class="text-center">
                        {{ 
                          trans('staff.role_option.' .  
                          config('common.role.' . $staffList->role))
                        }}
                    </td>
                    <td>
                        @if( Auth::user()['role'] > $staffList->role || Auth::id() == $staffList->id)
                            <button class="btn btn-primary" data-staff="{{$staffList}}" data-toggle="modal" data-target="#edit_modal-staff"><span class="fa fa-pencil"></span> {{trans('staff.edit')}}</button>
                        @endif
                        @if( Auth::user()['role'] > $staffList->role)    
                            <button class="btn btn-danger delete-staff" data-href="{{route('admin.staffs.delete', $staffList->id)}}" 
                                ><span class="fa fa-trash-o"></span> {{trans('staff.delete')}}
                            </button>
                        @endif


                    </td>
                </tr>              
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
  </div>
</section>
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_delete',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('partials.modal.body_cancel'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'confirmDelete',
])
@include('admin.staffs.create')
@include('admin.staffs.edit')
@stop
@section('javascript')
  <script src="{{ asset('admin/js/staff.js') }}"></script>
  <script>
      var route_store = <?php echo json_encode(route('admin.staffs.store')) ?>;
      var route_update = <?php echo json_encode(route('admin.staffs.update')) ?>;
  </script>
@stop