<?php
$dataType = 'create'; 
?>
<div id="Modal_add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">
                    {{trans('product.add')}}
                </h4>
            </div>
                <div class="modal-body">
                    @include('admin.products._form')
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
    window.createProductUrl = "{!! route('admin.products.store') !!}";
</script>