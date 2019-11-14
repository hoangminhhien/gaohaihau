<?php
$dataType = 'edit'; 
?>
<div id="Modal_edit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">
                    {{trans('product.edit')}}
                </h4>
            </div>
            <div class="modal-body">
                @include('admin.products._form')
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.updateProductUrl = "{!! route('admin.products.update') !!}";
</script>