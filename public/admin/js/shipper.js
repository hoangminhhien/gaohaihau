var loading_element = '<div class="d-flex-center"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></div>';
$(document).ready(function() {
    $(document).on('click','.click-toggle', function () {
        var thisSelector = $(this);
        thisSelector.find('.fix-icon-center').toggleClass('fa fa-angle-down ').toggleClass('fa fa-angle-up');
        thisSelector.parents('.acMenu').find(".shipper_detail").slideToggle();

        if(thisSelector.hasClass('open-title')) {
            thisSelector.removeClass('open-title');
        } else {
            thisSelector.addClass('open-title');
        }
    });

    // Set notification width
    $('.notification-icon .dropdown-menu').attr('style', 'width:' + $(window).width() + 'px !important');
    $('.notification-icon-logout .dropdown-menu').attr('style', 'width:' + $(window).width() + 'px !important');
   
    $('.history-tab').click(function () {
        $('#select-time').trigger('change');
    })
    $('.delivery-tab').click(function () {
        loadView({
            delivery_tab: true
        });
    })

    $('#select-time').change(function () {
        var data = {
            'time': $('#select-time').val(),
            history_tab: true
        };

       loadView(data);
    })

    // Open delivery modal
    $(document).on('click', '.open-delivery-modal', function(e){
        window.shipper_delivery_url = $(this).data('href');
        refreshModal();
        $('.delivery-modal').modal('show');
    });

    // Open camera
    $('#open_camera').click(function(){
        $('[name="delivery_image_url"]').click();
    })

    $('[name="delivery_image_url"]').change(function(e){
        _common.readUploadImage($('[name="delivery_image_url"]').prop('files'), '#open_camera');
        $('.open-camera-text').hide();
        $('.remove-image').show();
    });

    // Remove image
    $('.remove-image').click(function(e){
        e.stopPropagation();
        $('.open-camera-text').show();
        $('#open_camera').removeAttr('style');
        $('.remove-image').hide();
    });

    $('#deliveryForm').submit(function(e){
        e.preventDefault();
        var form_data = new FormData();
        var files = $('[name="delivery_image_url"]')[0].files[0];
        if(files){
            form_data.append('delivery_image_url', files);
        }

        form_data.append('remaining_rice_before_ship', $('[name="remaining_rice_before_ship"]').val());
        form_data.append('id', $('[name="id"]').val());

        _common.request(window.shipper_delivery_url,
            form_data, {
                method: 'POST',
                contentType: false,
                processData: false
            })
                .then(function(res){
                    $('.delivery-modal').modal('hide');
                    toastr.success(trans.shipper.delivery_success);
                    loadView({
                        delivery_tab: true
                    });
                })
                .catch(function(e){
                    console.log(e);
                });
    })
});

function refreshModal() {
    $('#deliveryForm input').val('');
    $('.error-message').empty();
    $('.remove-image').trigger('click');
}

function loadView(obj) {
    $('#history-tab .history-tab-content').html(loading_element);
    $('#delivery-tab').html(loading_element);
    _common.request(route_index, obj)
    .then(function (result) {
        if(obj.history_tab){
            $('#history-tab .history-tab-content').html(result);
            $('#select-time').select2({
                minimumResultsForSearch: -1
            });
        } else {
            $('#delivery-tab').html(result);
        }

    })
}

function onNotification(result) {
    if(!result || !result.data) return false;
    data = result.data;
    var toastrOption = {
        "positionClass": "toast-top-full-width",
        "toastClass": "opacity-1-i"
    };

    if(typeof data.remaining_total_view != 'undefined') {
        $(document).find('#remaining_total_view').html(data.remaining_total_view);
    }

    if(data.status == server_common.order.status.CONFIRMED) {
        if(typeof data.order_view != 'undefined') {
            $(document).find('#order_view').prepend(data.order_view);
        }
        toastr.success(result.content, result.title, toastrOption);
    }

    if(data.status == server_common.order.status.CANCELED) {
        $(document).find('.acMenu[data-id="' + data.id + '"]').remove();
        toastr.error(result.content, result.title, toastrOption);
    }
}

function notificationCallBack(result) {
    var id = null;
    var data = {};
    if(!result || !result.data) return false;

    try {
        data = JSON.parse(result.data);
    } catch(e) {
        console.error('Error JSON parse');
    }

    id = data.id;
    var clickSelector = $(document).find('.acMenu[data-id="' + id + '"] .open-delivery-modal');
    if(clickSelector) {
        clickSelector.click()
    }
}