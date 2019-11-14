<div class="box box-primary">
    <div class="box-header with-border">
        <h4>{{trans('crm.last_customer')}}</h4>
    </div>  
    <div class="box-body">
        <table class="table table-bordered list_order table-striped" >
            <thead>
                <tr>
                    <th>{{ trans('crm.code') }}</th>
                    <th>{{trans('crm.custo')}}</th>
                    <th>{{trans('crm.phone')}}</th>
                    <th>{{trans('crm.time')}}</th>
                    <th>{{trans('crm.delivered_time')}}</th>
                    <th>{{trans('crm.shipper')}}</th>
                    <th>{{trans('crm.due_date')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                 @foreach($last_customer as $last_customers)
                <tr>
                    <td class="text-center">{{$last_customers->order_id}}</td>
                    <td>{{$last_customers['customer']->name}}<br>
                        <i class="fa fa-building" aria-hidden="true"></i>
                        {{ViewHelper::customerAddress($last_customers['customer'])}}
                    </td>
                    <td>{{CommonHelper::formatPhonenumber($last_customers['customer']->phone)}}</td>
                    <td>
                        @if(!empty($last_customers['order']->delivery_time_expect_from ))
                            <p>{{ trans('delivery.list.from') }}: {{ date("d/m/Y H:i", strtotime($last_customers['order']->delivery_time_expect_from)) }}
                            </p>
                        @endif
                        @if(!empty($last_customers['order']->delivery_time_expect_to ))
                            <p>{{ trans('delivery.list.to') }}: {{ date("d/m/Y H:i", strtotime($last_customers['order']->delivery_time_expect_to)) }}</p>
                        @endif
                    </td>
                    <td>
                        @if(!empty($last_customers['order']->delivered_time))
                            {{date("d/m/Y H:i", strtotime($last_customers['order']->delivered_time))}}
                        @endif
                    </td>
                    <td>{{$last_customers['order']['shipper']->name}}</td>
                    <td >
                         <input class="form-control common-datepicker" type="text" name="due_date_last" value="{{date('Y-m-d H:i', strtotime($last_customers['due_date']))}}"  data-href="{{route('admin.crm.update', $last_customers->id)}}" format="DD/MM/YYYY HH:mm" time="true" time_24h="true" open_drop="down" applyButton="{{trans('crm.modal_out_of_rice.apply')}}" cancelButton="{{ trans('crm.modal_out_of_rice.cancel') }}"/>
                    </td>
                    <td class="crm_button">
                        <button type="button" class="btn btn-primary handle-button submit-button" data-href =" {{route('admin.crm.update', $last_customers['id'])}} ">{{ trans('crm.handle') }}
                        </button>
                        <button type="button" class="btn btn-danger cancel-button submit-button" data-href =" {{route('admin.crm.update', $last_customers['id'])}} ">{{ trans('crm.cacel') }}
                        </button>
                        <div>
                            <button type="button" class="btn btn-default submit-button delivered-order-button submit-button order_detail" data-type="show" data-id= "{{$last_customers['order']['id']}}" data-href=" {{ route('admin.deliveries.show') }}">{{ trans('delivery.list.order_detail') }}
                        </div>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $last_customer->appends(request()->input())->links() }}
        </div>
    </div>
</div> 
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_update',
    'title' => trans('crm.title'),
    'body' => trans('crm.confirm_handle'),
    'submit_label' => trans('crm.submit_label'),
    'cancel_label' => trans('crm.cancel_label'),
    'callback' => 'confirmUpdate',
])
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_cancel',
    'title' => trans('crm.title'),
    'body' => trans('crm.confirm_cancel'),
    'submit_label' => trans('crm.submit_label'),
    'cancel_label' => trans('crm.cancel_label'),
    'callback' => 'confirmCancel',
])