@extends('admin.layouts.index')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/order.css') }}">
@stop
@section('content_header')
    <h1><i class="fa fa-file-text-o"></i> {{trans('categories.category') }}</h1>
@stop
@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="row mb-20">
            <div class="col-sm-6">
                  <button type="button" data-toggle="modal" data-target="#create_modal-categories" class="btn btn-success submit-button" data-categories="{{$categoryLists}}"><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('categories.create') }}
                  </button>
            </div>
        </div>
        <table class="table table-bordered list_order table-striped" >
            <tbody>
                <tr>
                    <th style="width: 10px">{{ trans('categories.no') }}</th>
                    <th>{{ trans('categories.category') }}</th>
                    <th>{{ trans('categories.slug') }}</th>
                    <th>{{ trans('categories.parent_category') }}</th>
                    <th>{{ trans('categories.sequence') }}</th>
                    <th>{{ trans('categories.public') }}</th>
                    <th></th>
                </tr>
                @foreach($categoryLists as $key => $categoryList)
                  <tr>
                      <td class="text-center">{{$key+1}}</td>
                      <td>{{$categoryList->name}}</td>
                      <td>{{$categoryList->slug}}</td>
                      <td>{{$categoryList['parent']['name']}}</td>
                      <td class="text-center">{{$categoryList->sequence}}</td>
                      <td>
                          {{ 
                            trans('categories.category_status.' .  
                            config('common.category_status.' . $categoryList->is_public))
                          }}
                      </td>
                      <td>
                          <button class="btn btn-primary" data-toggle="modal" data-target="#edit_modal-categories" data-categories="{{$categoryList}}"><span class="fa fa-pencil"></span> {{trans('staff.edit')}}</button>
                          <button class="btn btn-danger delete-category" data-href="{{route('admin.categories.delete', $categoryList->id)}}"
                                  ><span class="fa fa-trash-o"></span> {{trans('staff.delete')}}
                          </button>
                      </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_delete',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('partials.modal.body_cancel'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'confirmDelete',
])
@include('admin.categories.create')
@include('admin.categories.edit')
@stop
@section('javascript')
  <script src="{{ asset('admin/js/category.js') }}"></script>
  <script>
      var route_store = <?php echo json_encode(route('admin.categories.store')) ?>;
      var route_update = <?php echo json_encode(route('admin.categories.update')) ?>;
  </script>
@stop