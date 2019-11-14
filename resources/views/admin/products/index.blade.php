@extends('admin.layouts.index')
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/product.css')}}">
@section('content_header')
    <h1><i class="fa fa-tasks" aria-hidden="true"></i> {{ trans('product.list_product')}}</h1>
@stop
@section('content')
@php
    $current_page = $products->currentPage();
    $no = ($current_page - 1) * 12;
@endphp
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
    <div class="container-fluid">
        <div class="row row-background ">
            <div class="box box-primary col-sm-12 table-body ">
                <button type="submit" class="btn btn-success style-button" data-toggle="modal" data-target="#Modal_add">
                    {{trans('product.create')}}
                </button>
                <table class="table table-bordered table-hover margin">
                    <tr>
                        <th>{{trans('product.stt')}}</th>
                        <th>{{trans('product.product_name')}}</th>
                        <th>{{trans('product.image')}}</th>
                        <th>{{trans('product.capacity')}}</th>
                        <th>{{trans('product.made_from')}}</th>
                        <th>{{trans('product.quantity')}}</th>
                        <th>{{trans('product.price')}}</th>
                        <th>{{trans('product.action')}}</th>
                    </tr>
                    @foreach($products as $product)
                    @php
                        $no++;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>
                            {{ $product->name }}
                            @if($product['gift_code'] == config('common.product.GIFT_CODE.NEWCUS.code'))
                                <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="images">
                                <div class="image1" style="background-image: url({{asset($product->image_url)}}) ">
                                </div>
                            </div>
                        </td>
                        <td class="text-right">
                            {{ $product->capacity }} {{ trans('common.kg_unit') }}
                        </td>
                        <td>
                            {{ $product->made_from }}
                        </td>
                        <td class="text-right">
                            <span>
                                {{CommonHelper::priceFormat($product->quantity) }}
                            </span>
                            @if($product->unit == 1)
                                <span>
                                    {{trans('common.products_unit_option.1')}}
                                </span>
                            @else
                                <span>
                                    {{trans('common.products_unit_option.2')}}
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            {{ CommonHelper::commonCurrency($product->price) }}
                        </td>
                        <td>
                            <button  class="btn btn-primary edit-button" data-toggle="modal" data-target="#Modal_edit" rel="{{$product}}">
                                {{trans('product.action_edit')}}
                            </button>
                            <button  class="btn btn-danger delete-button" data-href="{{route('admin.products.delete', $product->id)}}" >
                                {{trans('product.action_delete')}}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            <div id="paginate">
                {!! $products->appends(request()->input())->links() !!}
            </div>
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
@include('admin.products.create')
@include('admin.products.edit')
@endsection
@section('javascript')
<script type="text/javascript" src="{{asset('admin/js/products.js')}}"></script>
@stop