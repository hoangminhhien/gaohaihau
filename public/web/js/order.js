var timeout = null;
$(document).ready(function(){
    var screen_width = screen.width;
    if (screen_width > 767) {
        $('.product_screen_mobile').remove();
    }else{
        $('.product_screen_computer').remove();
    }
    setValueDatetimeDelivery();

    /*Event increase*/
    $('.quantity-plus').on('click', function(e) {
        var rowSelector = $(this).closest('[order-product]');
        var product_id = rowSelector.attr('product_id');
        var quantitySelector = rowSelector.find('.quantity');
        var newQuantity = (parseInt(quantitySelector.val()) || 0) + 1;
        quantitySelector.val(newQuantity);
        calcTotalRowPrice(rowSelector);
        changeOrderDataInCookie(product_id);
    });

    /*Event decrease*/
    $('.quantity-minus').on('click', function(e) {
        var rowSelector = $(this).closest('[order-product]');
        var product_id = rowSelector.attr('product_id');
        var quantitySelector = rowSelector.find('.quantity');
        var newQuantity = (parseInt(quantitySelector.val()) || 0);
        newQuantity = newQuantity - 1;
        if(newQuantity > 0) {
            quantitySelector.val(newQuantity);
            calcTotalRowPrice(rowSelector);
            changeOrderDataInCookie(product_id, -1);
        }
    });

    // Remove product
    $('.quantity-clear').on('click', function(e){
        var rowSelector = $(this).closest('[order-product]');
        var product_id = rowSelector.attr('product_id');
        rowSelector.remove();
        calcTotalPrice();
        changeOrderDataInCookie(product_id, 0);
        updateItemsCount();
    });

    // change quantity
    $('.quantity').keyup(function(){
        var thisSelector = $(this);
        var rowSelector = $(this).closest('[order-product]');
        var product_id = rowSelector.attr('product_id');
        var thisQuantity = parseInt(thisSelector.val()) || 1;
        calcTotalRowPrice(rowSelector);
        changeOrderDataInCookie(product_id, thisQuantity, true);
    });

    (function() {
        createOption('.project_list', projects);
        var building_list = [];
        var project_data = projects[$('.project_list').val()];
        if(project_data) {
            building_list = project_data['buildings'];
        }
        createOption('.building', building_list);
        var room_list = [];
        if(project_data && project_data['buildings'][$('.building').val()]) {
            room_list = project_data['buildings'][$('.building').val()][0];
        }
        createOption('.room', room_list);
    })();
    $(".select2").select2();

    $('.project_list').change(function(){
        var key = $(this).val();
        var buildings = [];
        if(projects[key]) {
            buildings = projects[key]['buildings'];
        }
        createOption('.building', buildings);
        createOption('.room', []);
    });

    $('.building').change(function(){
        var key = $(this).val();
        var project_data = projects[$('.project_list').val()];
        var rooms = [];
        if(project_data && project_data['buildings'][$('.building').val()]) {
            rooms = project_data['buildings'][$('.building').val()][0];
        }
        createOption('.room', rooms)
    });

    $(document).on('click', '.time_from', function(){
        setValueSelectTimeDelivery('.time_from')
    });
    $(document).on('click', '.time_to', function(){
        setValueSelectTimeDelivery('.time_to')
    });

     $('.number_kh').keyup(function(e){
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            checkPhoneUsed();
        }, 500);
     });

     $('#orderSubmitForm').submit(function(e){
        e.preventDefault();
        var thisSelector = $(this);
        var action = thisSelector.attr('action');
        var data = {};
        thisSelector.find('[name]').each(function(e){
            var thisSelector = $(this);
            var attr = thisSelector.attr('name');
            data[attr] = thisSelector.val();
        });

        data['product_id'] = {};
        data['quantity'] = {};

        $('[order-product]').each(function(e){
            var thisSelector = $(this);
            var product_id = thisSelector.attr('product_id');

            data['product_id'][product_id] = product_id;
            data['quantity'][product_id] = thisSelector.find('[rname="quantity"]').val();
        });

        _common.request(action, data , {method: 'POST'})
            .then(function (result) {
                $('#order_success').modal('show');
                $('.submit-order-button').hide();
                $('.back-to-home-button').show();
                // Clear in cookie
                $('.quantity-clear').each(function(e){
                    var rowSelector = $(this).closest('[order-product]');
                    var product_id = rowSelector.attr('product_id');
                    changeOrderDataInCookie(product_id, 0);
                    updateItemsCount();
                });
                $('input').addClass('convert-input-to-text');
                $('button').addClass('convert-input-to-text');
                $('.select2.select2-container').addClass('convert-input-to-text');
                $('.to-character').removeClass('text-center-i').addClass('text-left pl-0');
                $('.button-option-cart').hide();
                $('.change-quantity').addClass('text-right');
                $('.change-quantity input').addClass('text-right').removeAttr('disabled');
                $('.quantity-clear').hide();
                $('.error-message').remove();
                $('.required_address').hide();
                if(!$('[name="project_code"]').val()) $('[name="project_code"]').closest('div').hide();
                if(!$('[name="building_code"]').val()) $('[name="building_code"]').closest('div').hide();
                if(!$('[name="room_no"]').val()) $('[name="room_no"]').closest('div').hide();
            })
            .catch(function (e) {
                console.log(e);
            });
     });

    calcTotalPrice();
})

function myFunction() {
    var thisSelector = $(this);
    var project = $(".project_list").val();

}

function createOption(selected, array) {
    $(selected).empty();
    $(selected).append($('<option>', {value:"", text: 'Chọn một mục'}));
    $.each(array, function(key, value) {
         $(selected).append($('<option>', {value:value.code, text: value.code+' '+value.name}));
    });
}

function createUnit(array, thisSelector){
    var product_id = 0;
    if(thisSelector) {
        product_id = thisSelector.find('.list_sp').val();
    }
    $.each(array, function(key, value) {
        if(value['id'] == product_id ){
            $('.unit').html(" "+units[value['unit']])
        }
    });
}

function setValueDatetimeDelivery(){
    var minute_step = $('.delivery_time').attr('minute_step');
    hour = moment().format('H');
    minute_current = moment().format('m');
    minute_total = parseInt(minute_current) + parseInt(minute_step);
    minute_floor = Math.floor(minute_total / minute_step);
    minute = minute_step * minute_floor;
    if(minute == 60){
        hour = parseInt(hour) + (minute / 60);
        minute = minute % 60 ;
    }
    hour_to = parseInt(hour) + 1;

    datetime_from = moment({ hour: hour, minute: minute }).format('YYYY-MM-DD HH:mm')
    datetime_to = moment({ hour: hour_to, minute: minute }).format('YYYY-MM-DD HH:mm')
    $('.time_from').val(datetime_from);
    $('.time_to').val(datetime_to);
}

function setValueSelectTimeDelivery(selected){
    var value = $(selected).val();
    if(value == ''){
        time_hour = '7';
        time_minute = '00';
    }else{
        var result = value.split(' ');
        var time = result[1].split(':');
        time_hour = time[0]
        time_minute = time[1]
    }
    $('.hourselect').val(time_hour)
    if(time_minute == '00'){
        time_minute = '0';
    }
    $('.minuteselect').val(time_minute)
}

function checkPhoneUsed() {
    $(".promotion_product").remove();
    $('.name_kh').val('');
    $(".customer_id").val('');
    var phone= $('.number_kh').val();
    if (phone.length >= 10) {
        _common.request(route_getInfoCustomer, {'phone': phone} , {method: 'GET'})
            .then(function (result) {
                if(Object.getOwnPropertyNames(result).length){
                    $(".customer_id").val(result['id']);
                    $(".name_kh").val(result['name']);
                    $(".project_list").val(result['project_code']).change();
                    $(".building").val(result['building_code']).change();
                    $(".room").val(result['room_no']).change();
                    $(".number_kh").val(result['phone']);
                    $(".address_kh").val(result['address']);
                }else {
                    gift_process();
                }
            })
            .catch(function (e) {
            });
    }
}

function calcTotalRowPrice(rowSelector) {
    rowSelector = $(rowSelector);
    var productPrice = parseInt(rowSelector.find('[rname="price"]').attr('value')) || 0;
    var productQuantity = parseInt(rowSelector.find('[rname="quantity"]').val());
    var totalPrice = productPrice * productQuantity;
    var totalPriceSelector = rowSelector.find('[rname="total-price"]');
    totalPriceSelector.html(_common.formatCurrency(totalPrice));
    totalPriceSelector.attr('value', totalPrice);
    calcTotalPrice();
}

function calcTotalPrice() {
    var totalOrderProductsPrice = 0;
    $('[order-product]').each(function(e){
        thisSelector = $(this);
        totalPrice = parseInt(thisSelector.find('[rname="total-price"]').attr('value')) || 0;
        totalOrderProductsPrice += totalPrice;
    });
    $('[rname="total-order-price"]').html(_common.formatCurrency(totalOrderProductsPrice));
}

function updateItemsCount() {
    var cookie_value = $.cookie('order');
    if(cookie_value){
        $('#items-count').text($.parseJSON(cookie_value).length);
    }
}

// Delete all product
function openDeleteAllProductConfirmModal() {
    $('#delete_all_product_confirm').modal('show');
}

function deleteAllProductConfirm() {
    $('.quantity-clear').trigger('click');
    calcTotalPrice();
}

function openSubmitOrderConfirmModal() {
    $('#submit_order_confirm').modal('show');
}

function submitOrder() {
    $('#orderSubmitForm').submit();
}

function gift_process(){
    var i;
    var _line_html = [];
    var content;
    for(i in promotion_products){
        if (screen.width > 767) {
            content = [
                "<td>",
                    "<div class='product-image'>",
                        "<img src='"+promotion_products[i].image_url+"' width='50px' height='50px'>",
                    "</div>",
                    "<div class='product-name'>" + promotion_products[i].name + " <span class='label label-warning'> "+trans.web_order.gift_content+" </span> ",
                    "</div>",
                "</td>",
                "<td class='text-right' rname='price'>",
                    _common.formatCurrency(0),
                "</td>",
                "<td class='text-center change-quantity'>",
                    "<input class='form-control quantity common-numeric' rname='quantity' value='1' disabled>",
                "</td>",
                "<td class='text-right' rname='total-price' value = '0'>",
                    _common.formatCurrency(0),
                "</td>",
            ];
        }else{
            content = [
                "<td>",
                    "<div>",
                        "<div class='product-image'>",
                            "<img src='"+promotion_products[i].image_url+"' width='50px' height='50px'>",
                        "</div>",
                        "<div class='product-name'>" + promotion_products[i].name + "("+ promotion_products[i].capacity+ trans.common.kg_unit + ")",
                            "<span class='label label-warning'> "+trans.web_order.gift_content+" </span> ",
                        "</div>",
                    "</div>",
                    "<div class='mb-10'>",
                        "<div class='pull-left'>"+trans.web_order.price+ "</div>",
                        "<div class='text-right pull-right' rname='price'>",
                           _common.formatCurrency(0),
                        "</div>",
                        "<div class='clear'></div>",
                    "</div>",
                    "<div class='mb-10'>",
                        "<div class='pull-left'>" + trans.web_order.quantity,
                        "</div>",
                        "<div class='text-right change-quantity pull-right'>",
                            "<input class='form-control quantity common-numeric' rname='quantity' value='1' disabled>",
                        "</div>",
                        "<div class='clear'></div>",
                    "</div>",
                    "<div class='mb-10'>",
                        "<div class='pull-left'>"+trans.web_order.total_price,
                        "</div>",
                        "<div class='text-right pull-right' rname='total-price' value='0'>",
                           _common.formatCurrency(0),
                        "</div>",
                        "<div class='clear'></div>",
                    "</div>",
                "</td>",
            ]
        }
        _line_html = _line_html.concat(
            [ "<tr class='promotion_product' order-product product_id = '"+promotion_products[i].id+"'>",],
            content,
            ["</tr>"]
        );
    }
    $(_line_html.join('')).insertBefore($(".total-order-price"));
}
