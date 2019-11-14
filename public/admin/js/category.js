jQuery(document).ready(function () {
    $('#create_modal-categories').on('shown.bs.modal', function (e) {
        $('.error-message').empty();
    })
    jQuery('#create_submit_categories').click(function (e) {
        var data = {
            name: jQuery('#create_name').val(),
            slug: jQuery('#create_slug').val(),
            parent_category: jQuery('#create_parent_category').val(),
        };
        if($('#create_is_public').prop('checked') == true){
            data['is_public'] = $('#create_is_public').val();
        }    
        _common.request(route_store, data, { method: 'POST'})
            .then(function(res){
                toastr.success('Xóa thành công!');
                setTimeout(function(){
                    location.reload();
                },1000);
            })
            .catch(function(err){
    
            });
    });

    $('#edit_modal-categories').on('show.bs.modal', function (event) {
        $('.error-message').empty();
        var button = $(event.relatedTarget);
        var categoriesList = button.data('categories');
        var id_edit = categoriesList['id'];
        var modal = $(this);
        if(categoriesList.is_public) {
             $('#edit_is_public').prop('checked', true);
        } else {
            $('#edit_is_public').prop('checked', false);
        }
        modal.find('.modal-body #edit_name').val(categoriesList.name);
        modal.find('.modal-body #edit_slug').val(categoriesList.slug);
        modal.find('.modal-body #edit_id').val(categoriesList.id);
    });

    $('span .select2-selection').on('focus', function(event){
        var product_name = $('#edit_name').val();
        $('ul li:contains("' + product_name + '"):last').css('display', 'none');
    })

    jQuery('#edit_submit_categories').click(function (e) {
        var data = {
             name : jQuery('#edit_name').val(),
             slug : jQuery('#edit_slug').val(),
             parent_category : jQuery('#edit_parent_category').val(),
             id : jQuery('#edit_id').val(),
        }
        if($('#edit_is_public').prop('checked') == true){
            data['is_public'] = $('#edit_is_public').val();
        }
        _common.request(route_update, data, { method: 'POST'})
            .then(function(res){
                toastr.success('Xóa thành công!');
                setTimeout(function(){
                    location.reload();
                },1000);
            })
            .catch(function(err){

            });
    });
    $('.delete-category').click(function(){
        $('#confirm_delete').modal('show');
        currentSelector = $(this);
    });

})
function confirmDelete() {
    var href = currentSelector.data('href');
    _common.request(href, null, {method: 'POST'})
        .then(function(result){
            toastr.success('Xóa thành công!');
            setTimeout(function(){
                location.reload();
            },1000);
        })
    .catch(function(error){
    });
}