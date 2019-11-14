<div class="box">
    <div class="box-header with-border ready_delivery">
        <p>{{ trans('delivery.list.delivered_table_label') }}</p>
    </div>    <div class="box-body">
        <table class="table table-bordered list_order table-striped delivered" >
            <thead>
                <tr>
                    <th style="width: 120px">{{ trans('delivery.list.code_order') }}</th>
                    <th class="name-customer-column">{{ trans('delivery.list.name_customer') }}</th>
                    <th class="phone-column">{{ trans('delivery.list.phone') }}</th>
                    <th class="quantity-column">{{ trans('delivery.list.quantity_cate') }}</th>
                    <th class="total-price-column">{{ trans('delivery.list.total_price') }}</th>
                    <th class="time-column">{{ trans('delivery.list.delivered_time') }}</th>
                    <th class="action-column"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($delivered_orders as $key => $order)
                    @include('admin.deliveries._order_table_template')
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $delivered_orders->appends(['o2' => $orders->currentPage(), 'o1' => $customer_orders->currentPage(), 'o3' => $delivered_orders->currentPage()], request()->input())->links()}}
        </div>
        <div class="box-footer clearfix">
        </div>
    </div>
</div>
{{-- Approve confirm --}}
@include('admin.partials.confirm', [
    'modal_id' => 'approve_confirm',
    'title' => trans('partials.modal.confirm_title'),
    'body' => trans('order.approve_confirm.body'),
    'submit_label' => trans('partials.modal.ok'),
    'cancel_label' => trans('partials.modal.close'),
    'callback' => 'approveConfirm',
])