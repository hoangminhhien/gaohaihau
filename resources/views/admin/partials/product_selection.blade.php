<select
    @if(isset($partial_name)) name="{{ $partial_name }}" @endif
    @if(isset($partial_id)) id="{{ $partial_id }}" @endif
    class="form-control select2">
    @if (isset($product_selection_list))
        @foreach($product_selection_list as $item)
            <option value="{{ $item['id'] }}" unit="{{ $item['unit'] }}">{{ $item['name'] }} ({{ $item['capacity'] }} kg)</option>
        @endforeach
    @endif
</select>