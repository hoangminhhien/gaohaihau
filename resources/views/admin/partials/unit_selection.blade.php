<select
    @if(isset($partial_name)) name="{{ $partial_name }}" @endif
    @if(isset($partial_id)) id="{{ $partial_id }}" @endif
    class="form-control select2"
    disable_search="true"
>
    @foreach(config('common.products_unit') as $item)
        <option value="{{$item}}">
            {{ trans('common.products_unit_option.' . $item) }}
        </option>
    @endforeach
</select>