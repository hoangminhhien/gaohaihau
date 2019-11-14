@extends('admin.layouts.index')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/building.css')}}">
@stop
@section('content')
@section('content_header')
<h1><i class="fa fa-tasks" aria-hidden="true"></i> {{$project['project_code']}} - {{$project['name']}}</h1>
@stop
@if($errors->any())
    <div id="error">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="box-body box">
    <div class="row mb-5">
        <div class="col-sm-6 button-create mb-10">
            <button {{ PermissionHelper::view('admin.building.edit_building') }} class="btn btn-primary create_building " data-toggle="modal" data-target="#edit_building" rel="{{$project}}"><i class="fa fa-list-alt" aria-hidden="true"></i> {{trans('building_room.create_building')}}</button>
        </div>
    </div>
    <table class="table table-bordered table-hover">
            <tr>
                <th style="width: 15%">{{trans('building_room.building')}}</th>
                <th style="width: 65%">{{trans('building_room.rooms')}}</th>
                <th style="width: 10%">{{trans('building_room.proportion')}}</th>
                <th style="width: 10%">{{trans('building_room.action')}}</th>
            </tr>
        @foreach($buildings as $building)
            <tr>
                <td>
                    {{$building['building_code']}} - {{$building['name']}}
                </td>
                <td>
                    @php
                        $count = 0;
                    @endphp
                    @if(!$building->rooms->isEmpty())
                        @foreach($building->rooms as $room)
                            @if(!$room->customers->isEmpty())
                                @php
                                    $count++;
                                @endphp
                            @endif
                        <a href="{{route('admin.customer.index', [$project['project_code'], $building['building_code'], $room['room_no']])}}">
                            <span class="label label-default label-room @if(!$room->customers->isEmpty()) rooms @endif " room_no="{{ $room['room_no'] }}">
                                {{ $room['room_no'] }}
                            </span>
                        </a>
                        @endforeach
                    @endif
                </td>
                <td>
                    <div class="progress ">
                        <div class="progress-bar color" role="progressbar" style="width: {{round($count/(sizeof($building->rooms)?sizeof($building->rooms):1)*100, 2)}}%;" aria-valuenow="{{round($count/(sizeof($building->rooms)?sizeof($building->rooms):1)*100, 2)}}" aria-valuemin="0" aria-valuemax="100">{{round($count/(sizeof($building->rooms)?sizeof($building->rooms):1)*100, 2)}}%</div>
                    </div>
                </td>
                <td>
                    <div>
                        <button {{ PermissionHelper::view('admin.building.edit_building') }} class="btn btn-primary edit_building" data-toggle="modal" data-target="#edit_building" rel="{{$building}}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <button {{ PermissionHelper::view('admin.building.delete_building') }} type="button" class="btn btn-danger delete-button" data-href="{{ route('admin.building.delete_building', $building->id) }}" id="delete-button">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

</div>
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_delete',
    'title' => trans('project.title'),
    'body' => trans('project.body'),
    'submit_label' => trans('project.submit_label'),
    'cancel_label' => trans('project.cancel_label'),
    'callback' => 'confirmDelete',
])
@section('javascript')
<script type="text/javascript" src="{{asset('admin/js/building_rooms.js')}}""></script>
@stop
@include('admin.buildings.edit_building')
@endsection
