<div class="box box-primary">
    <div class="box-header with-border">
        <h4>{{trans('crm.order_after.name_list')}}</h4>
    </div>
    <div class="box-body">
        <table class="table table-bordered list_order table-striped">
            <thead>
                <tr>
                    <th>{{ trans('crm.order_after.no') }}</th>
                    <th>{{ trans('crm.name_customer') }}</th>
                    <th>{{ trans('crm.phone') }}</th>
                    <th>{{ trans('crm.order_after.order_product') }}</th>
                    <th>{{ trans('crm.order_after.date_order') }}</th>
                    <th>{{ trans('crm.due_date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($getListCustomerLate3Month as $key => $item)
                @php
                    $customer_data = $item['customer'];
                    $issue_data = null;
                    $valid_issue = false;
                    if(!empty($item['customer']['customer_issue'])) {
                        $issue_data = $item['customer']['customer_issue'];
                        $valid_issue = $issue_data['created_at'] >= $item['created_at'];
                    }
                @endphp
                <tr>
                    <td class="text-center">{{$item['customer']['id']}}</td>
                    <td>
                        {{$customer_data['name']}}<br>
                        <i class="fa fa-building" aria-hidden="true"></i>
                        {{ViewHelper::customerAddress($customer_data)}}
                    </td>
                    <td>{{CommonHelper::formatPhonenumber($customer_data['phone'])}}</td>
                    <td >
                        <ul>
                            @foreach($item['orderProduct'] as $key => $orderProuct)
                                @if(empty($orderProuct['product'])) @continue @endif

                                <li><span class="color-red" >{{ $orderProuct['quantity'] }}</span> x {{ $orderProuct['product']->name }} ({{ $orderProuct['product']['capacity'] }} {{trans('shipper.kg_unit')}})
                                    @if(CommonHelper::checkGiftCode($item, $orderProuct))
                                        <span class="label label-warning">{{trans('delivery.list.discount')}}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        {{date("d/m/Y H:i", strtotime($item['created_at']))}}
                    </td>
                    <td>
                        @if(!empty($issue_data['due_date']) && $valid_issue)
                            @if($issue_data['status'] == config('common.issue.status.PENDING'))
                                <input class="form-control common-datepicker no_order_3_month_datepicker"
                                    type="text"
                                    value="{{date('Y-m-d H:i', strtotime($issue_data['due_date']))}}"
                                    data-href="{{route('admin.crm.update', $issue_data['id'])}}"
                                    format="DD/MM/YYYY HH:mm"
                                    time="true"
                                    time_24h="true"
                                    open_drop="up"
                                    applyButton="{{trans('crm.modal_out_of_rice.apply')}}"
                                    cancelButton="{{ trans('crm.modal_out_of_rice.cancel') }}"
                                />
                            @else
                                {{ date('d/m/Y H:i', strtotime($issue_data['due_date'])) }}
                            @endif
                        @else
                            <span class="text-danger">{{ trans('crm.order_after.no_create_issue') }}</span>
                        @endif
                    </td>
                    <td class="crm_button">
                        @if($valid_issue)
                            <div class="mb-5">
                                @if($issue_data['status'] == config('common.issue.status.PENDING'))
                                    <button type="button" class="btn btn-primary submit-button open_resolve_3_month" data-href="{{ route('admin.crm.update', $issue_data['id']) }}">
                                        {{ trans('crm.resolve_issue') }}
                                    </button>
                                    <button type="button" class="btn btn-danger submit-button open_cancel_3_month" data-href="{{ route('admin.crm.update', $issue_data['id']) }}">
                                        {{ trans('crm.cancel_issue') }}
                                    </button>
                                @else
                                    <span class="text-red">
                                        {{ trans('crm.resolved_at') }}: {{ date('d/m/Y H:i', strtotime($issue_data['updated_at'])) }}
                                    </span>
                                @endif
                            </div>
                        @endif
                        <div>
                            @if(!$valid_issue)
                                <button type="button"
                                    class="btn btn-success submit-button open_create_3_month"
                                    data-href="{{ route('admin.crm.create') }}"
                                    data-customer_id="{{ $item['customer_id'] }}"
                                >
                                    {{ trans('crm.create_issue') }}
                                </button>
                            @endif
                            <button type="button" class="btn btn-default submit-button delivered-order-button" data-type="show" data-id= "{{$item['id']}}" data-href=" {{ route('admin.deliveries.show') }}">{{ trans('delivery.list.order_detail') }}</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $getListCustomerLate3Month->appends(request()->input())->links() }}
        </div>
    </div>
</div>

{{-- Create confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_create_3_month',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('crm.order_after.create_modal.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'submitCreate3Month',
])

{{-- Resolve confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_resolve_3_month',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('crm.order_after.resolve_modal.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'submitResolve3Month',
])

{{-- Cancel confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_cancel_3_month',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('crm.order_after.cancel_modal.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'submitCancel3Month',
])