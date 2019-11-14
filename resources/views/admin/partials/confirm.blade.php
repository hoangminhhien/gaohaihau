<div class="modal z-index-10000 modal-mobile" id="{{isset($modal_id) ? $modal_id : '' }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title">
          @if(isset($title))
            {{ $title }}
          @else
            {{ trans('partials.modal.confirm_title') }}
          @endif
        </label>
        @if(!isset($is_hide_close))
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        @endif
      </div>
      <div class="modal-body">
        @if(isset($body))
          {{ $body }}
        @endif
      </div>
      <div class="modal-footer">
        @if(!isset($is_hide_close))
            <a href="javascript:void(0)" class="btn btn-secondary" data-dismiss="modal">
              @if(isset($cancel_label))
                {{ $cancel_label }}
              @else
                {{ trans('partials.modal.close') }}
              @endif
            </a>
        @endif
        @if(isset($submit_form_id))
          <button type="button" onclick="$('#{{ $submit_form_id }}').submit()" class="btn btn-primary click-show-loading">
            @if(isset($submit_label))
              {{ $submit_label }}
            @else
              {{ trans('partials.modal.ok') }}
            @endif
          </button>
        @elseif(isset($callback))
          <button type="button" onclick="if(typeof {{$callback}} == 'function') {{$callback}}(); $('#{{$modal_id}}').modal('hide')" class="btn btn-primary">
            @if(isset($submit_label))
              {{ $submit_label }}
            @else
              {{ trans('partials.modal.ok') }}
            @endif
          </button>
        @else
          <a href="{{isset($direct_url) ? $direct_url : 'javascript:void(0)'}}" onclick="$('#{{$modal_id}}').modal('hide')" class="btn btn-primary click-show-loading">
          @if(isset($submit_label))
            {{ $submit_label }}
          @else
            {{ trans('partials.modal.ok') }}
          @endif
        </a>
        @endif
      </div>
    </div>
  </div>
</div>