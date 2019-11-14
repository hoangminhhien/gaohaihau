jQuery(document).ready(function () {

    $('#create_modal-staff').on('shown.bs.modal', function (e) {
        $('.error-message').empty();
    })
    jQuery('#create_submit_Staff').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: route_store,
            method: 'post',
            data: {
                name: jQuery('#create_name').val(),
                password: jQuery('#create_password').val(),
                email: jQuery('#create_email').val(),
                role: $('#create_role').val()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                _common.showErrorMessage(jqXHR);
                $('loading').hide();
            },
            success: function (result) {
                location.reload();
            }
        });
    });

    $('#edit_modal-staff').on('show.bs.modal', function (event) {
        $('.error-message').empty();
        var button = $(event.relatedTarget)
        var staffList = button.data('staff')
        var id_edit = staffList['id']

        if($user.id == id_edit){
            $('.role_select').prop('disabled', true);
        }else{
            $('.role_select').prop('disabled', false);
        }
        
        var modal = $(this)
        modal.find('.modal-body #edit_name').val(staffList.name)
        modal.find('.modal-body #edit_email').val(staffList.email)
        modal.find('.modal-body #edit_role').val(staffList.role)
        modal.find('.modal-body #edit_password').val(staffList.password)
        modal.find('.modal-body #edit_id').val(staffList.id)

    });

    jQuery('#edit_submit_Staff').click(function (e) {
        var data = {
             name : jQuery('#edit_name').val(),
             email : jQuery('#edit_email').val(),
             role : jQuery('#edit_role').val(),
             id : jQuery('#edit_id').val(),
        }
        if(!$('#edit_password').prop('disabled')){
            data['password'] = jQuery('#edit_password').val();
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: route_update,
            method: 'post',
            data: data,
            error: function (jqXHR, textStatus, errorThrown) {
                _common.showErrorMessage(jqXHR);
                $('loading').hide();
            },
            success: function (result) {
                location.reload();
            }
        });
    });

    $('.switch').on('click',function() {
        if( $('#edit_password').prop('disabled') ) { 
            $('#edit_password').prop('disabled',false);
            $(".turnON-turnOF").text("Tắt sửa mật khẩu");
        } 
        else {
            $('#edit_password').prop('disabled',true);
            $(".turnON-turnOF").text("Bật sửa mật khẩu");
        }
    });

    $('.delete-staff').click(function(){
        $('#confirm_delete').modal('show');
        currentSelector = $(this);
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