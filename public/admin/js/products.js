var currentSelector = null;
$(document).ready(function(){
    $('.edit-button').click(function(){
        var current = $(this).attr("rel");
        var currents = JSON.parse(current);
        $('#edit_id').val(currents.id);
        $('#edit_name').val(currents.name);
        $('#edit_made_from').val(currents.made_from);
        $('#edit_unit_'+currents.unit).attr('selected',true);
        $('#edit_catagory_'+currents.category_id).attr('selected',true);
        $('#edit_capacity').val(currents.capacity);
        $('#edit_price').val(currents.price);
        $('#edit_short_desc').val(currents.short_desc);
        $('#edit_desc').val(currents.desc);
        $('#edit_quantity').val(currents.quantity);
        $('.type_select').val(currents.type);
        $('.type_select_discount').val(currents.gift_code);
        if(currents.is_public) {
             $('#edit_is_public').prop('checked', true);
        } else {
            $('#edit_is_public').prop('checked', false);
        }
    });
    $(document).on('submit', '.submit-form', function(e){
        e.preventDefault();
        var thisSelector = $(this);
        var form_type = thisSelector.attr('id');
        var form_data = new FormData();
        var files = thisSelector.find('[name="image"]')[0].files[0];
        var is_public = server_common.product.IS_PUBLIC.INACTIVE;

        if( thisSelector.find('[name="is_public"]').prop('checked')){
            is_public = server_common.product.IS_PUBLIC.ACTIVE;
        }
        form_data.append('is_public', is_public);

        if(files){
            form_data.append('image', files);
        }
        var url = window.createProductUrl;
        if(form_type == 'edit_product_form') {
            url = window.updateProductUrl;
        }
        thisSelector.find('[name]').each(function(){
            var thisSelector = $(this);
            var attr = thisSelector.attr('name');
            if(['is_public', 'image'].indexOf(attr) > -1) {
                return;
            }
            var value = thisSelector.val();
            form_data.append(attr, value);
        });
        _common.request(
            url,
            form_data,
            { method: 'POST',
                contentType: false,
                processData: false
            })
            .then(function(res){
                location.reload();
            })
            .catch(function(){
            });
    })
    $('.delete-button').click(function(){
        $('#confirm_delete').modal('show');
        currentSelector = $(this);
    });

    setTimeout(function(){
        $('#error').hide();
      },5000);

    $(document).on('change', '.type_select_discount', function(e){
        currentSelector = $(this);
        if(currentSelector.val() == server_common.product.GIFT_CODE.NEWCUS.code){
            $('#create_price').val(0);
            $('#edit_price').val(0);
        }
    });
});

function confirmDelete() {
    var href = currentSelector.data('href');
    _common.request(href, {_token: $('[name="csrf-token"]').attr('content')}, {method: 'POST'})
    .then(function(result){
        toastr.success('Xóa thành công!');
        setTimeout(function(){
        location.reload();
      },1000);
    })
    .catch(function(error){

    });
}
