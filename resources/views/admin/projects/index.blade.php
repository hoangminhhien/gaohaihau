@extends('admin.layouts.index')
@section('content')
@section('content_header')
    <h1><i class="fa fa-tasks" aria-hidden="true"></i> {{ trans('project.list')}}</h1>
@stop
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/project.css')}}">
<div class="box box-primary">
    <div class="row mb-5">
        <div {{ PermissionHelper::view('admin.projects.store') }} class="col-sm-6 button-create">
            <button type="submit" data-toggle="modal" data-target="#modal_add" class="btn btn-success submit-button"><i class="fa fa-list-alt" aria-hidden="true"></i> {{trans('project.create_project')}}
            </button>
        </div>
    </div>
    <div class="box-body">
        <table id="example2" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>{{ trans('project.edit_id')}}</th>
                    <th>{{ trans('project.code')}}</th>
                    <th>{{ trans('project.name')}}</th>
                    <th>{{ trans('project.action')}}</th>
                </tr>
            </thead>
            @foreach($projects as $project)
            <tr>
                <td class="text-center">{{$project['id']}}<input type="hidden" id="id" name="id" value="{{$project->id}}"></td>
                <td>{{$project->project_code}}<input type="hidden" id="eidt_project_code" name="edit_project_code" value="{{$project->project_code}}"></td>
                <td>{{$project->name}}<input type="hidden" id="edit_name" name="edit_name" value="{{$project->name}}"></td>
                <td>
                    <button {{ PermissionHelper::view('admin.projects.update') }} class="btn btn-primary edit-button" data-toggle="modal" data-target="#modal_edit" data-project="{{$project}}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button {{ PermissionHelper::view('admin.projects.delete') }} type="button" data-href="{{route('admin.projects.delete', $project->id)}}"  class="btn btn-danger delete-button">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <a href="{{route('admin.building.index', $project->project_code)}}">
                    <button type="button" class="btn btn-warning">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
        <div id="paginate">
            {!! $projects->appends(request()->input())->links() !!}
        </div>
    </div>
</div>
@include('admin.partials.confirm', [
'modal_id' => 'confirm_delete',
'title' => trans('project.title'),
'body' => trans('project.body'),
'submit_label' => trans('project.submit_label'),
'cancel_label' => trans('project.cancel_label'),
'callback' => 'confirmDelete',
])
@endsection
<!-- code edit -->
@include('admin.projects.edit')
<!-- code add -->
@include('admin.projects.create')
@section('javascript')
<script type="text/javascript" src="{{asset('admin/js/project.js')}}"></script>
<script type="text/javascript">
    var route_store = <?php echo json_encode(route('admin.projects.store')) ?>;
    var route_update = <?php echo json_encode(route('admin.projects.update')) ?>;
    
</script>
@stop