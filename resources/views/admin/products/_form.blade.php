<link rel="stylesheet" type="text/css" href="{{asset('admin/css/product.css')}}">
<form class="form-horizontal submit-form " id="{{$dataType}}_product_form" enctype="multipart/form-data">
<div class="container-fluid">
{{csrf_field()}}
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.category')}}</label>
    <div class="col-sm-9">
    <select class="mdb-select md-form form-control" name="category" >
        @foreach($categories as $category)
        <option id="{{$dataType}}_catagory_{{$category->id}}" value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
    </select>
    </div>
</div>
<div class="form-group">
    <input type="hidden" class="form-control" id="{{$dataType}}_id" name="id" value="" required="">
    <label class="col-sm-3 control-label">{{trans('product.product_name')}} </label>
    <div class="col-sm-9">
        <input type="text" id="{{$dataType}}_name" class="form-control" name="name" >
        <div class="name-errors"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.made_from')}}</label>
    <div class="col-sm-9">
    <input type="text" id="{{$dataType}}_made_from" class="form-control" name="made_from" >
    <div class="made_from-errors"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.price')}}</label>
    <div class="col-sm-9">
    <input type="text" id="{{$dataType}}_price" name="price" class="form-control common-currency">
    <div class="price-errors"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.unit')}}</label>
    <div class="col-sm-9">
    <select class="mdb-select md-form form-control" name="unit" >
        @foreach(config('common.products_unit') as $option)
        <option id="{{$dataType}}_unit_{{$option}}" value="{{$option}}">{{ trans('common.products_unit_option.' . $option) }}</option>
        @endforeach
    </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.capacity')}}</label>
    <div class="col-sm-9">
    <input type="text" id="{{$dataType}}_capacity" name="capacity" class="form-control common-capacity">
    <div class="capacity-errors"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.image')}}</label>
    <div class="col-sm-9">
    <input type="file" id="{{$dataType}}_image" class="form-control" name="image" accept="image/*">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.type')}}</label>
    <div class="col-sm-9">
    <select class="mdb-select md-form form-control type_select" name="type">
        @foreach(config('common.product.type') as $option)
        <option id="{{$dataType}}_type" value="{{$option}}">{{ trans('common.products_type_option.' . $option) }}</option>
        @endforeach
    </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{trans('product.gift_code')}}</label>
    <div class="col-sm-9">
    <select class="mdb-select md-form form-control type_select_discount" name="gift_code">
        <option id="{{$dataType}}_type" value>{{trans('product.no_discount')}}</option>
        @foreach(config('common.product.GIFT_CODE') as $option)
            <option id="{{$dataType}}_type" value="{{$option['code']}}">{{$option['code']}}</option>
        @endforeach
    </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-12 control-label">{{trans('product.short')}}</label>
    <div class="col-sm-12">
    <textarea class="form-control" rows="3" id="{{$dataType}}_short_desc" name="short_desc" ></textarea>
    <div class="short_desc-errors"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-12 control-label">{{trans('product.desc')}}</label>
    <div class="col-sm-12">
    <textarea class="form-control" rows="3" id="{{$dataType}}_desc" name="desc" ></textarea>
    <div class="desc-errors"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{trans('product.public')}}</label>
    <div class="col-sm-3">
        <label class="switch">
            <input type="checkbox" id="{{$dataType}}_is_public" name="is_public" >
            <span class="slider round"></span>
        </label>
    </div>
</div>
<div class="pull-right">
    <button type="button" class="btn btn-default " data-dismiss="modal">{{trans('product.close')}}</button>
    <button type="submit" class="btn btn-primary submit-button" id="btn_thuchien">{{trans('product.ok')}}</button>
</div>
</div>
</form>