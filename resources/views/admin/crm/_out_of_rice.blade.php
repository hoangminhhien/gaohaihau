<div class="box box-primary">
    <div class="box-header with-border">
        <h4>{{ trans('crm.out_of_rice_title') }}</h4>
    </div>
    <div class="box-body">
        <table class="table table-bordered list_order table-striped">
            <thead>
                <tr>
                    <th>{{ trans('crm.order_after.no') }}</th>
                    <th>{{trans('crm.name_customer')}}</th>
                    <th>{{trans('crm.phone')}}</th>
                    <th>{{ trans('crm.due_date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($out_of_rices as $item)
                 <tr>
                    <td class="text-center">{{$item->id}}</td>
                    <td>
                        {{ $item['customer']->name }}<br>
                        <i class="fa fa-building" aria-hidden="true"></i>
                        {{ ViewHelper::customerAddress($item['customer']) }}
                    </td>
                    <td>
                        {{ CommonHelper::formatPhonenumber($item['customer']->phone) }}
                    </td>
                    <td class="due_date">
                        <input class="form-control common-datepicker" type="text" name="due_date" value="{{date('Y-m-d H:i', strtotime($item['due_date']))}}"  data-href="{{route('admin.crm.update', $item->id)}}" format="DD/MM/YYYY HH:mm" time="true" time_24h="true" open_drop="up" applyButton="{{trans('crm.modal_out_of_rice.apply')}}" cancelButton="{{ trans('crm.modal_out_of_rice.cancel') }}"/>
                    </td>
                    <td class="crm_button">
                        <div class="handle_or_cancel">
                            <span>
                                <button type="button" class="btn btn-primary handle_issue submit-button" data-href="{{route('admin.crm.update', $item->id)}}" >{{ trans('crm.handle_issue') }}</button>
                            </span>
                            <span>
                                <button type="button" class="btn btn-danger cancel_out_of_rice_issue submit-button" data-href="{{route('admin.crm.update', $item->id)}}">{{ trans('crm.cancel_issue') }}</button>
                            </span>
                        </div>
                        <div class="new_order">
                             <button type="button" data-issue_id="{{$item->id}}" class="btn btn-success confirm-order submit-button" data-type="create" data-id= "{{ $item->order_id }}" data-href="{{ route('admin.deliveries.edit') }}">{{ trans('crm.customer_new_order') }}</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $out_of_rices->appends(request()->input())->links()}}
        </div>
    </div>
</div>
@include('admin.partials.confirm', [
    'modal_id' => 'confirm_handle',
    'title' => trans('crm.modal_out_of_rice.title'),
    'body' => trans('crm.modal_out_of_rice.body_handle'),
    'submit_label' => trans('crm.modal_out_of_rice.submit'),
    'cancel_label' => trans('crm.modal_out_of_rice.cancel'),
    'callback' => 'handleIssueOutOfRice',
])
@include('admin.partials.confirm', [
    'modal_id' => 'cancel_out_of_rice_issue',
    'title' => trans('crm.modal_out_of_rice.title'),
    'body' => trans('crm.modal_out_of_rice.body_cancel'),
    'submit_label' => trans('crm.modal_out_of_rice.submit'),
    'cancel_label' => trans('crm.modal_out_of_rice.cancel'),
    'callback' => 'cancelIssueOutOfRice',
])