@php
    $current_page = $import_history_list->currentPage();
    $no = ($current_page - 1) * 5;
@endphp
<table class="table table-bordered table-striped">
    <thead>
        <th>{{ trans('inventory.no') }}</th>
        <th>{{ trans('inventory.product_name') }}</th>
        <th>{{ trans('inventory.quantity_unit') }}</th>
        <th>{{ trans('inventory.created_at') }}</th>
        <th>{{ trans('inventory.import_price') }}</th>
        <th {{ PermissionHelper::view('admin.inventories.delete') }}></th>
    </thead>
    <tbody>
        @foreach($import_history_list as $item)
            @php
                $no++;
            @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>
                <td>
                    @if(isset($item['product']))
                        {{ $item['product']['name'] }} ({{ $item['product']['capacity'] }} kg)
                    @endif
                </td>
                <td>
                    {{ $item['quantity'] }}
                    @if(isset($item['product']))
                        {{ strtolower(trans('common.products_unit_option.' . $item['product']['unit'])) }}
                    @endif
                </td>
                <td>
                    {{ date('d/m/Y', strtotime($item['created_at'])) }}
                </td>
                <td class="text-right">
                    {{ CommonHelper::commonCurrency($item['price']) }}
                </td>
                <td {{ PermissionHelper::view('admin.inventories.delete') }}>
                    <button type="button" class="btn btn-danger pull-right delete-button submit-button" data-href="{{ route('admin.inventories.delete', $item['id']) }}">
                        <i class="fa fa-trash"></i> {{ trans('inventory.delete') }}
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex-center">
    {{ $import_history_list->appends(request()->input())->links() }}
</div>