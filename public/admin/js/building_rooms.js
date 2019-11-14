$(document).ready(function(){
    $('.edit_building').click(function(){
        var thisSelector = $(this);
        var current = $(this).attr("rel");
        var currents = JSON.parse(current);
        $('#id_building').val(currents.id);
        $('#projects_code_fake').val(currents.project_code);
        $('#projects_code').val(currents.project_code);
        $('#buildings_code_fake').val(currents.building_code);
        $('#buildings_code').val(currents.building_code);
        $('#buildings_code').attr('disabled', 'disabled');
        $('#building_name').val(currents.name);
        $('#building-modal-title').html('Chỉnh sửa toà nhà');
        var room_array = [];
        thisSelector.closest('tr').find('[room_no]').each(function(e){
            var thisSelector = $(this);
            var room = thisSelector.attr('room_no');
            room_array.push(room);
        });

        $('#list_room').empty().trigger('change');
        for(var i = 0; i <room_array.length; i++){
            var data = {
                text: room_array[i]
            };
            var newOption = new Option(data.text);
            $('#list_room').append(newOption).trigger('change');
        };
        $('#list_room').val(room_array).trigger('change');
    });
    $('.create_building').click(function(){
        clearModalData();
        var thisSelector = $(this);
        var project = JSON.parse($(this).attr("rel"));
        $('#projects_code_fake').val(project.project_code);
        $('#projects_code').val(project.project_code);
        $('#building-modal-title').html('Tạo toà nhà');
        $('#buildings_code').removeAttr('disabled');
        $('#list_room').empty().trigger('change');
    });
    $('select').select2({
      tags: true,
        tokenSeparators: [',', ' ']
    });
    $('.delete-button').click(function(){
        $('#confirm_delete').modal('show');
        currentSelector = $(this);
    });

    $('select').on(
        'select2:close',
        function () {
            $(this).focus();
        }
    );

    setTimeout(function(){
        $('#error').hide();
      },5000);
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

function clearModalData(){
    $('#id_building').val('');
    $('#projects_code_fake').val('');
    $('#projects_code').val('');
    $('#buildings_code_fake').val('');
    $('#buildings_code').val('');
    $('#building_name').val('');
    $('.select2-selection__rendered').html('');
}

