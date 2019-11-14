$(document).ready(function (event) {
    // Handle check data
    $('[name="check_all_order"]').click(function(e){
        var thisSelector = $(this);
        if(thisSelector.is(':checked')) {
            $('.check_order').prop('checked', true);
        } else {
            $('.check_order').prop('checked', false);
        }
        $('#check_all_current_page').prop('checked', false);
    });

    // Handle check data
    $('#check_all_current_page').click(function(e){
        var thisSelector = $(this);
        if(thisSelector.is(':checked')) {
            $('.check_order').prop('checked', true);
        } else {
            $('.check_order').prop('checked', false);
        }
        $('[name="check_all_order"]').prop('checked', false);
    });

    $('.check_order').click(function(e){
        var thisSelector = $(this);
        if(!thisSelector.is(':checked')) {
            $('[name="check_all_order"]').prop('checked', false);
            $('#check_all_current_page').prop('checked', false);
        }
    });

    // Submit approve order
    $('#approve_order_button').click(function(event){
        $('#approve_confirm').modal('show');
    });

    // Open confirm cancel order
    $('#cancel_approve_order_button').click(function(event){
        $('#cancel_approve_confirm').modal('show');
    });
});

function getRequestData() {
    var data = {
        delivery_time_expect_from: $('[name="delivery_time_expect_from"]').val(),
        delivery_time_expect_to: $('[name="delivery_time_expect_to"]').val(),
        shipper_id: $('[name="shipper_id"]').val(),
    };

    if($('[name="check_all_order"]').is(':checked')) {
        data.all_id = true;
    } else {
        data.id = [];
        $('.check_order').each(function(){
            var thisSelector = $(this);
            if(thisSelector.is(':checked')) {
                data.id.push(thisSelector.data('id'));
            }
        });
    }
    return data;
}

function approveConfirm() {
    var data = getRequestData();
    _common.request($approve_url, data, { method: 'POST'})
        .then(function(res){
            location.reload();
        })
        .catch(function(err){

        });
}

function cancelApproveConfirm() {
    var data = getRequestData();
    _common.request($cancel_approve_url, data, { method: 'POST'})
        .then(function(res){
            location.reload();
        })
        .catch(function(err){

        });
}