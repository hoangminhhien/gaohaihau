$(document).ready(function () {
    $('#modal_add').on('shown.bs.modal', function (e) {
        $('.error-message').empty();
    })
    $(document).on('submit', '#create_submit_product', function (e) {
        e.preventDefault();
        var data = {
            project_code: jQuery('#project_code').val(),
            name: jQuery('#name1').val(),
        };
        _common.request(route_store, data, {
                method: 'POST'
            })
            .then(function (res) {
                toastr.success('Thành công!');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            })
            .catch(function (err) {

            });
    });

    $('#modal_edit').on('show.bs.modal', function (event) {
        $('.error-message').empty();
        var button = $(event.relatedTarget);
        var projectList = button.data('project');
        var id_edit = projectList['id'];
        var modal = $(this);
        modal.find('.modal-body #edit_name').val(projectList.name);
        modal.find('.modal-body #edit-project_code').val(projectList.project_code);
        modal.find('.modal-body #edit_id').val(projectList.id);
    });

    $(document).on('submit', '#edit_submit_product', function (e) {
        e.preventDefault();
        var data = {
            project_code: jQuery('#edit-project_code').val(),
            name: jQuery('#edit_name').val(),
            id: jQuery('#edit_id').val(),
        };
        _common.request(route_update, data, {
                method: 'POST'
            })
            .then(function (res) {
                toastr.success('Thành công!');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            })
            .catch(function (err) {

            });
    });

    $('.delete-button').click(function () {
        $('#confirm_delete').modal('show');
        currentSelector = $(this);
    });

});

function confirmDelete() {
    var href = currentSelector.data('href');
    _common.request(href, null, {
            method: 'POST'
        })
        .then(function (result) {
            toastr.success('Xóa thành công!');
            setTimeout(function () {
                location.reload();
            }, 1000);
        })
        .catch(function (error) {

        });
}