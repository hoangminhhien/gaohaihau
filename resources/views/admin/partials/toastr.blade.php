@if(session('submit_success'))
    <div class="toastr-success" title="" content="
        @if(session('submit_success') == 'create')
            {{ trans('partials.toastr.create.body') }}
        @elseif(session('submit_success') == 'update')
            {{ trans('partials.toastr.update.body') }}
        @elseif(session('submit_success') == 'delete')
            {{ trans('partials.toastr.delete.body') }}
        @elseif(session('submit_success') == 'approve')
            {{ trans('partials.toastr.approve.body') }}
        @elseif(session('submit_success') == 'cancel_approve')
            {{ trans('partials.toastr.cancel_approve.body') }}
        @endif
    "></div>
    @php
        Session::forget('submit_success');
    @endphp
@endif