<div class="box box-primary">
    <div class="box-header with-border">
        <h4>{{trans('crm.new_order')}}</h4>
    </div>    
    <div class="box-body">
        <table class="table table-bordered list_order table-striped">
            <thead>
                <tr>
                    <th>{{ trans('crm.code') }}</th>
                    <th>{{ trans('crm.name_customer') }}</th>
                    <th>{{ trans('crm.phone') }}</th>
                    <th>{{ trans('crm.date') }}</th>
                    <th>{{ trans('crm.due_date') }}</th>
                    <th></th>
                </tr>
            </thead>    
            <tbody>
                @foreach($getListNewCustomer as $key => $item)
                <tr>
                    <td class="text-center">{{$item['order']['id']}}</td>
                    <td>
                        {{$item['customer']->name}}<br>
                        <i class="fa fa-building" aria-hidden="true"></i>
                        {{ViewHelper::customerAddress($item['customer'])}}
                    </td>
                    <td>{{CommonHelper::formatPhonenumber($item['customer']->phone)}}</td>
                    <td>{{date("d/m/Y H:i:s", strtotime($item['order']['created_at']))}}</td>
                    <td>
                        <input class="form-control submit_new_customer" id="date_due"  time_24h="true" type="text" name="datetimes" autocomplete="off" value="{{date("d/m/Y H:i:s", strtotime($item['due_date']))}}"  data-href="{{route('admin.crm.update', $item->id)}}"/>
                    </td>
                    <td class="crm_button">
                        <span class="space-fix"><button type="button" class="btn btn-primary submit-button new_customer_button" data-href="{{route('admin.crm.update', $item->id)}}">{{ trans('crm.issue_order') }}</button></span>
                        <span class="delivered-delete"><button class="btn btn-danger cancel_new_customer_button submit-button" 
                            data-href="{{route('admin.crm.update', $item->id)}}">{{ trans('crm.delete_order') }}</button></span>
                        <div class="fix-detail"><button type="button" class="btn btn-default submit-button delivered-order-button detail-button" data-type="show" data-id= "{{$item['order']['id']}}" data-href=" {{ route('admin.deliveries.show') }}">{{ trans('crm.detail_order') }}</button></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $getListNewCustomer->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@include('admin.partials.confirm', [
    'modal_id' => 'new_customer_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('crm.customer_confirm'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'newCustomerConfirm',
])

@include('admin.partials.confirm', [
    'modal_id' => 'cancel_new_customer_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('crm.customer_cancel'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'CancelNewCustomerConfirm',
])       