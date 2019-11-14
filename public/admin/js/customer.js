$(document).ready(function(){
    $('#Modal_edit').on('show.bs.modal', function (event) {
        $('.error-message').empty();
        var button = $(event.relatedTarget);
        var customers = button.data('customers');
        var id_edit = customers['id'];
        var modal = $(this);
        modal.find('.modal-body #edit_name').val(customers.name);
        modal.find('.modal-body #edit_phone').val(customers.phone);
        modal.find('.modal-body #edit-project_code').val(customers.project_code);
        modal.find('.modal-body #edit-project').val(customers.project_code).change();
        modal.find('.modal-body #edit-building').val(customers.building_code).change();
        modal.find('.modal-body #edit-room').val(customers.room_no).change();
        modal.find('.modal-body .address_kh').val(customers.address);
        modal.find('.modal-body #family_number_of_children').val(customers.family_number_of_children);
        modal.find('.modal-body #family_number_of_adults').val(customers.family_number_of_adults);
        modal.find('.modal-body #remaining_rice').val(customers.remaining_rice);
        modal.find('.modal-body #edit_id').val(customers.id);
    });

    $('#edit_submit_customer').on('submit',function (e) {
        e.preventDefault();
        var data = {
            name : $('#edit_name').val(),
            phone : $('#edit_phone').val(),
            project_code : $('#edit-project').val(),
            building_code : $('#edit-building').val(),
            room_no : $('#edit-room').val(),
            family_number_of_children : $('#family_number_of_children').val(),
            family_number_of_adults : $('#family_number_of_adults').val(),
            remaining_rice : $('#remaining_rice').val(),
            address : $('.address_kh').val(),
            id : $('#edit_id').val()
        }
        _common.request(route_update, data, { method: 'POST'})
            .then(function(res){
                toastr.success(trans.customer.update_success);
                setTimeout(function(){
                    location.reload();
                },1000);
            })
            .catch(function(err){

            });
    });

    $('.delete-button').click(function(){
        $('#confirm_delete').modal('show');
        currentSelector = $(this);
    });
    setTimeout(function(){
        $('#error').hide();
      },5000);
});
function confirmDelete() {
    var href = currentSelector.data('href');
    _common.request(href, {}, {method: 'POST'})
    .then(function(result){
        toastr.success('Xóa thành công!');
        setTimeout(function(){
        location.reload();
      },1000);
    })
    .catch(function(error){

    });
}