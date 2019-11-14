<form id="create_inventory_form" class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-1 control-label">
            {{ trans('inventory.product') }}
        </label>
        <div class="col-sm-3">
            @include('admin.partials.product_selection', [ 'partial_name' => 'product_id' ])
            <div class="product_id-errors"></div>
        </div>
        <label class="col-sm-1 control-label text-center-i">
            <i class="fa fa-close"></i>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="quantity" class="form-control common-numeric" placeholder="{{ trans('inventory.quantity') }}">
                <div class="input-group-addon" name="product_unit">{{ trans('common.products_unit_option.1') }}</div>
            </div>
            <div class="quantity-errors"></div>
        </div>
        <div class="col-sm-3">
            <input type="text" name="price" class="form-control common-currency" placeholder="{{ trans('inventory.import_price') }}">
            <div class="price-errors"></div>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-success pull-right submit-button">
                <i class="fa fa-bank"></i>
                {{ trans('inventory.import_button') }}
            </button>
        </div>
    </div>
</form>