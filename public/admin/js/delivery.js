var customer_list_search = [];
var timeout = null;
var dataType = null;
$(document).ready(function(){
    $(document).on('click', '.add_order_delivery', function() {
        var thisSelector = $(this);
        dataType = thisSelector.data('type');
        $('#'+dataType+'_modal-delivery').modal('show');
    })
    createUnit(products, $('.modal'));
    $('.list_sl').val(1);
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
    setValueDatetimeDelivery();
    $('#create_modal-delivery').on('hidden.bs.modal', function(e) {
        deleteValueinput();
        $('.name_kh').val('');
        $('.number_kh').val('');
        $('.choose_info').remove();
        $(".showsp").html('');
    });
    $('#edit_modal-delivery').on('hidden.bs.modal', function(e) {
        var thisSelector = $(this);
        deleteValueinput();
        $('.name_kh').val('');
        $('.number_kh').val('');
        setValueDatetimeDelivery()
        $('.choose_info').remove();
        $(".showsp").html('');
        createOption('.project_list', projects);
        if (projects[thisSelector.find('.project_list').val()]) {
            createOption('.building', projects[$('.project_list').val()]['buildings']);
        }
        if(thisSelector.find('.project_list').val()) {
            createOption('.room', projects[thisSelector.find('.project_list').val()]['buildings'][$('.building').val()][0]);
        }
    });

    $('#show_modal-delivery').on('hidden.bs.modal', function(e) {
        var thisSelector = $(this);
        deleteValueinput();
        $('#show_modal-delivery .name_kh').val('');
        $('#show_modal-delivery .number_kh').val('');
        setValueDatetimeDelivery()
        $('#show_modal-delivery .choose_info').remove();
        $('#show_modal-delivery .showsp').html('');
        createOption('#show_modal-delivery .project_list', projects);
        if (projects[thisSelector.find('.project_list').val()]) {
            createOption('#show_modal-delivery .building', projects[thisSelector.find('.project_list').val()]['buildings']);
        }
        if (projects[thisSelector.find('.project_list').val()]) {
            createOption('#show_modal-delivery .room', projects[thisSelector.find('.project_list').val()]['buildings'][$('#show_modal-delivery .building').val()][0]);
        }
    });

    $(".bt_add").click(function(){
        var thisSelector = $(this);
        var parentSelector = thisSelector.closest('#'+dataType+'_modal-delivery');
        var product_id = parentSelector.find('.list_sp').val();
        var name = parentSelector.find('.list_sp option:selected').html()
        var quantity = parentSelector.find(".list_sl").val();
        var capacity;
        var price;
        var unit;
        var i;
        var is_duplicate_product = false;

        setTimeout(function () {
            $('#'+dataType+'_product_id-errors').html('')
        }, 3000);

        if(!quantity || quantity == 0){
            $('#'+dataType+'_product_id-errors').html('<div class = "error-message">'+trans.delivery.error.quantity_require+'</div');
            return;
        }

        for (i in products) {
            if(products[i]['id'] == product_id ){
                capacity = products[i]['capacity']; 
                price = products[i]['price'];
                unit = units[products[i]['unit']];
                quantity_product = products[i]['quantity'];
                if(quantity > products[i]['quantity']){
                    $('#'+dataType+'_product_id-errors').html('<div class = "error-message">'+trans.delivery.error.out_of_quantity+'</div');
                    return;
                }
            }
        }

        parentSelector.find( ".showsp .show_sp" ).each(function( index ) {
            var thisSelector = $(this);
            var id = thisSelector.find('.product_id').val();

            if (id === product_id) {
                is_duplicate_product = true;
                var qtt = Number(quantity) + Number(thisSelector.find('.qtt_sp').val());
                if(qtt > quantity_product){
                    $('#'+dataType+'_product_id-errors').html('<div class = "error-message">'+trans.delivery.error.out_of_quantity+'</div');
                    return; 
                }else{
                    var _line_html = [
                            name+" - "+" x "+qtt+" "+unit,
                            "<span onclick='deleteRow(this)' class='pull-right'><i class='fa fa-times-circle'></i></span>",
                            "<input type='hidden' class='form-control product_id' name= 'product_id["+product_id+"]' value='"+product_id+"' disabled>",
                            "<input type='hidden' class='form-control name_sp' name= 'name_sp' value='"+name+"' disabled>",
                            "<input type='hidden' class='form-control qtt_sp' name ='quantity["+product_id+"]' value='"+qtt+"' disabled>",
                            "<input type='hidden' class='form-control price_sp' name ='price["+product_id+"]' value='"+price+"' disabled>"
                            ].join('\n');
                    thisSelector.html(_line_html);
                    return;
                }
            }
        });
        if(!is_duplicate_product) {
            var _line_html = [
                "<div class='show_sp'>"+name+" - "+" x "+quantity+" "+unit,
                "<span onclick='deleteRow(this)' class='pull-right'><i class='fa fa-times-circle'></i></span>",
                "<input type='hidden' class='form-control product_id' name= 'product_id["+product_id+"]' value='"+product_id+"' disabled>",
                "<input type='hidden' class='form-control name_sp' name= 'name_sp' value='"+name+"' disabled>",
                "<input type='hidden' class='form-control qtt_sp' name ='quantity["+product_id+"]' value='"+quantity+"' disabled>",
                "<input type='hidden' class='form-control price_sp' name ='price["+product_id+"]' value='"+price+"' disabled></div>",
            ].join('\n');
            $(".showsp").append(_line_html);
        }
    });
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
        var thisSelector = $(this);
        var key = $(this).val();
        var closest_modal = $(this).closest('.modal-body');
        var find_select = closest_modal.find('.project_list');
        var project_data = projects[find_select.val()];
        var rooms = [];
        if(project_data && project_data['buildings'][thisSelector.val()]) {
            rooms = project_data['buildings'][thisSelector.val()][0];
        }
        createOption('.room', rooms)
    });

    $('.info_kh').keyup(function(e){
        var thisSelector = $(this);
        var name = thisSelector.attr('name')
        var value = thisSelector.val()
        var parentSelector = thisSelector.closest('#'+dataType+'_modal-delivery');
        var $listItems = parentSelector.find('.choose_info li');
        var selector = thisSelector.closest('.phone').find('.phone-info')

        var key = e.keyCode,
            $selected = $listItems.filter('.selected')
        if ( key == 40 || key == 38 || key == 37 || key == 39) return;
        if ( key != 40 && key != 38 && key != 13 ){
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                checkPhoneUsed(value, selector);
            }, 500);
            
        }
        if (key == 13) {
            if ( ! $selected.length ) {
                return;
            }else{
                var key1 = $selected.attr('index');
                if(key1){
                    $(".customer_id").val(customer_list_search[key1]['id']);
                    $(".name_kh").val(customer_list_search[key1]['name']);
                    $(".project_list").val(customer_list_search[key1]['project_code']).change();
                    $(".building").val(customer_list_search[key1]['building_code']).change();
                    $(".room").val(customer_list_search[key1]['room_no']).change(); 
                    $(".number_kh").val(customer_list_search[key1]['phone']);
                    $('.family_number_of_adults').val(customer_list_search[key].family_number_of_adults);
                    $('.family_number_of_children').val(customer_list_search[key].family_number_of_children);
                }
                $('.choose_info').remove();
            }
        }

    });

    $('.list_sp').change(function(){
        createUnit(products, $(this).closest('.modal'))
    });

    $('#create_submit').click(function() {
        deleteValueinput();
        saveAddorUpdate(route_store);
    });
    $(document).on('click', '.choose_info_true', function() {
        var thisSelector = $(this);
        var key = thisSelector.attr('index');
        if(key){
            $(".customer_id").val(customer_list_search[key]['id']);
            $(".name_kh").val(customer_list_search[key]['name']);
            $(".project_list").val(customer_list_search[key]['project_code']).change();
            $(".building").val(customer_list_search[key]['building_code']).change();
            $(".room").val(customer_list_search[key]['room_no']).change(); 
            $(".number_kh").val(customer_list_search[key]['phone']);
            $(".address_kh").val(customer_list_search[key]['address']);
            $('.family_number_of_adults').val(customer_list_search[key].family_number_of_adults);
            $('.family_number_of_children').val(customer_list_search[key].family_number_of_children);
        }
        $('.choose_info').remove();
    });

    $(document).on('click', '.time_from', function(){
        setValueSelectTimeDelivery('.time_from')
    });
    $(document).on('click', '.time_to', function(){
        setValueSelectTimeDelivery('.time_to')
    });

    $('.delete-order').click(function(e){
        e.stopPropagation();
        $('#modal-cacel').modal('show');
        currentSelector = $(this);
    });

    $('.modal-cacel').click(function(e){
        e.stopPropagation();
        $('loading').show();
        var order_id = currentSelector.data('order_id');
        var canceled_note = $("input[name='canceled_note']").val();
        var href = currentSelector.data('href');
        var data = {
             order_id : order_id,
             canceled_note : canceled_note,
        }
         _common.request(href, data , {method: 'POST'})
            .then(function(result){
                toastr.success(result.success);
                setTimeout(function function_name(argument) {
                    location.reload();
                },500)
            })
        .catch(function(error){
        });
    })

    $(document).on('click', '.confirm-order', function(e){
        e.stopPropagation();
        var thisSelector = $(this);
        var href = thisSelector.data('href')
        dataType = thisSelector.data('type');
        var issue_id = thisSelector.data('issue_id');
        if (typeof issue_id != 'undefined'){
            $('.issue_id').val(issue_id);
        }
        var data = {
             id : thisSelector.data('id'),
        }
         _common.request(href, data , {method: 'GET'})
            .then(function(result){
                $('#'+dataType+'_modal-delivery').modal('show');
                $('.order_id').val(result.id);
                $('.name_kh').val(result.customer.name);
                $('.customer_id').val(result.customer.id);
                $('.number_kh').val(result.customer.phone);
                $('.project_list').val(result.customer.project_code).change();
                $('.building').val(result.customer.building_code).change();
                $('.room').val(result.customer.room_no).change();
                $('.address_kh').val(result.customer.address);
                $('.family_number_of_adults').val(result.customer.family_number_of_adults);
                $('.family_number_of_children').val(result.customer.family_number_of_children);
                $('.shipper_id').val(result.shipper_id).change();
                if (dataType == 'create') {
                    setValueDatetimeDelivery();
                }else{
                    $('.time_from').val(result.delivery_time_expect_from);
                    $('.time_to').val(result.delivery_time_expect_to);
                }
                for(i in result.order_product){
                    $(".productId").append("<input type='hidden' class='form-control id_sp' name ='order_product_id["+result.order_product[i].product_id+"]' value='"+result.order_product[i].id+"' disabled>")
                    var is_promotion_product = result.order_product[i].product.gift_code == server_common.product.GIFT_CODE.NEWCUS.code;
                    var close_div = "";
                    if(is_promotion_product) {
                        close_div += "<span class='label label-warning'>"+trans.delivery.gift.content+" </span>"
                    }
                    close_div += "</div>"
                    $(".showsp").append([
                        "<div class='show_sp'>" +result.order_product[i].product.name+" ("+result.order_product[i].product.capacity+" kg)"+" - "+result.order_product[i].quantity+" x "+ units[result.order_product[i].product.unit],
                            "<span onclick='deleteRow(this)' class='pull-right'><i class='fa fa-times-circle'></i></span>",
                            "<input type='hidden' class='form-control product_id' name= 'product_id["+result.order_product[i].product_id+"]' value='"+result.order_product[i].product_id+"' disabled>",
                            "<input type='hidden' class='form-control name_sp' name= 'name_sp' value='"+result.order_product[i].product.name+"' disabled>",
                            "<input type='hidden' class='form-control qtt_sp' name ='quantity["+result.order_product[i].product_id+"]' value='"+result.order_product[i].quantity+"' disabled>",
                            "<input type='hidden' class='form-control price_sp' name ='price["+result.order_product[i].product_id+"]' value='"+result.order_product[i].product.price+"' disabled>",
                            "<input type='hidden' class='form-control id_sp' name ='order_product_id["+result.order_product[i].product_id+"]' value='"+result.order_product[i].id+"' disabled>",
                        close_div
                    ].join('\n'));
                }
            })
        .catch(function(error){
        });
    })

    // Delivered order
    $(document).on('click', '.delivered-order-button, .delivery-button', function(e){
        e.stopPropagation();
        var thisSelector = $(this);
        var href = thisSelector.data('href')
        dataType = thisSelector.data('type');
        var data = {
             id : thisSelector.data('id'),
        }
         _common.request(href, data)
            .then(function(result){
                $('#'+dataType+'_modal-delivery .order_id').val(result.id);
                $('#'+dataType+'_modal-delivery .name_kh').val(result.customer.name);
                $('#'+dataType+'_modal-delivery .customer_id').val(result.customer.id);
                $('#'+dataType+'_modal-delivery .number_kh').val(result.customer.phone);
                $('#'+dataType+'_modal-delivery .project_list').val(result.customer.project_code).change();;
                $('#'+dataType+'_modal-delivery .building').val(result.customer.building_code).change();;
                $('#'+dataType+'_modal-delivery .room').val(result.customer.room_no).change();
                $('#'+dataType+'_modal-delivery .address_kh').val(result.customer.address);
                $('#'+dataType+'_modal-delivery .time_from').val(result.delivery_time_expect_from);
                $('#'+dataType+'_modal-delivery .time_to').val(result.delivery_time_expect_to);
                $('#'+dataType+'_modal-delivery .delivered_time').val(result.delivered_time);
                $('#'+dataType+'_modal-delivery .family_number_of_adults').val(result.customer.family_number_of_adults);
                $('#'+dataType+'_modal-delivery .family_number_of_children').val(result.customer.family_number_of_children);
                $('#'+dataType+'_modal-delivery .shipper_id').val(result.shipper_id).change();
                for(i in result.order_product){
                    $('#'+dataType+'_modal-delivery .productId').append("<input type='hidden' class='form-control id_sp' name ='order_product_id["+result.order_product[i].product_id+"]' value='"+result.order_product[i].id+"' disabled>")
                    var is_promotion_product = result.order_product[i].product.gift_code == server_common.product.GIFT_CODE.NEWCUS.code;
                    var close_div = "";
                    if(is_promotion_product) {
                        close_div += "<span class='label label-warning'>"+trans.delivery.gift.content+" </span>"
                    }
                    close_div += "</div>"
                    $('#'+dataType+'_modal-delivery .showsp').append([
                            "<div class='show_sp'>" +result.order_product[i].product.name+" ("+result.order_product[i].product.capacity+" kg)"+" - "+result.order_product[i].quantity+" x "+ units[result.order_product[i].product.unit],
                                "<span onclick='deleteRow(this)' class='pull-right'><i class='fa fa-times-circle'></i></span>",
                                "<input type='hidden' class='form-control product_id' name= 'product_id["+result.order_product[i].product_id+"]' value='"+result.order_product[i].product_id+"' disabled>",
                                "<input type='hidden' class='form-control name_sp' name= 'name_sp' value='"+result.order_product[i].product.name+"' disabled>",
                                "<input type='hidden' class='form-control qtt_sp' name ='quantity["+result.order_product[i].product_id+"]' value='"+result.order_product[i].quantity+"' disabled>",
                                "<input type='hidden' class='form-control price_sp' name ='price["+result.order_product[i].product_id+"]' value='"+result.order_product[i].product.price+"' disabled>",
                                "<input type='hidden' class='form-control id_sp' name ='order_product_id["+result.order_product[i].product_id+"]' value='"+result.order_product[i].id+"' disabled>",
                            close_div
                        ].join('\n'));
                }
                $('#'+dataType+'_modal-delivery input, #'+dataType+'_modal-delivery select').attr('disabled', true);
                $('#'+dataType+'_modal-delivery .select2 .select2-selection, #'+dataType+'_modal-delivery .show_sp').addClass('disable-click');
                $('#'+dataType+'_modal-delivery .bt_add').hide();
                $('#'+dataType+'_modal-delivery .order_id').attr('disabled', false);

                $('#'+dataType+'_modal-delivery').modal('show');
            })
        .catch(function(error){
        });
    })

    $('#edit_submit').click(function() {
        deleteValueinput();
        saveAddorUpdate(update_route);
    });

    $('#delivery_submit').click(function() {
        deleteValueinput();
        saveAddorUpdate(delivery_route);
    });

    $('.info_kh').keydown(function(e)
    {
        var thisSelector = $(this);
        var parentSelector = thisSelector.closest('#'+dataType+'_modal-delivery');
        var $listItems = parentSelector.find('.choose_info li');

        var key = e.keyCode,
            $selected = $listItems.filter('.selected'),
            $current;

        if ( key != 40 && key != 38 ) return;

        $listItems.removeClass('selected');

        if ( key == 40 ) // Down key
        {
            if ( ! $selected.length ) {
                $current = $listItems.eq(0);
            } else if($selected.is(':last-child')){
                 $current = $listItems.eq(0);
                 $('.choose_info').scrollTop($('.choose_info li:nth-child(6)').position().top);
            }
            else {
                $current = $selected.next();
            }

            if($current.attr('index') == 5 ){
                $('.choose_info').scrollTop($('.choose_info li:nth-child(6)').position().top);
            }
        }
        else if ( key == 38 ) // Up key
        {
            if ( ! $selected.length || $selected.is(':first-child') ) {
                $current = $listItems.last();
                $('.choose_info').scrollTop($('.choose_info li:nth-child(6)').position().top);
            }
            else {
                $current = $selected.prev();
            }

            if($current.attr('index') == 4 ){
                $('.choose_info').scrollTop($('.choose_info li:nth-child(6)').position().top);
            }
        }
        $current.addClass('selected');
    });

    //Approve confirm
    $(document).on('click', '.approve_order_button', function(e){
        e.stopPropagation();
        $('#approve_confirm').modal('show');
        current_Selector = $(this);
    });

    // show detail order
    $(document).on('click', '.show-order-detail', function(e){
        e.stopPropagation();
        $(this).find('.delivered-order-button').click();
    });
});

function deleteRow(thisSelector) {
    thisSelector = $(thisSelector); 
    thisSelector.closest('.show_sp').remove();
}

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
function checkPhoneUsed(data, selector) {
    $(".promotion").remove();
    _common.request(route_getInfoCustomer, {'data': data} , {method: 'GET'})
        .then(function (result) {
            $('.choose_info').remove();
            customer_list_search = result;
            if(result != ''){
                selector.html('<ul class="choose_info"></ul>')
                $.each(result, function(key,value){
                    $('.choose_info').append('<li class="choose_info_true" index="' + key + '">'+value.phone+'-'+value.name+'</li>');
                })
            }else{
                gift_process();
            }
        })
        .catch(function (e) {
        });
}

function deleteValueinput(){
    $('#'+ dataType +'_name-errors').html('');
    $('#'+ dataType +'_phone-errors').html('');
    $('#' +dataType +'_product_id-errors').html('');
    $('#' +dataType +'_delivery_time_expect_to-errors').html('');
}
function saveAddorUpdate(href) {
    var elements = document.getElementById(dataType+"_delivery").elements;
    var obj ={};

    for(var i = 0 ; i < elements.length ; i++){
        var item = elements.item(i);
        obj[item.name] = item.value;
    }
    _common.request(href, obj , {method: 'POST', use_loading: true})
        .then(function (result) {
            toastr.success(result.success);
            setTimeout(function function_name(argument) {
                location.reload();
            },500)
        })
        .catch(function (e) {
            for (i in e.responseJSON.errors){
                if(i){
                    $(document).find('#'+dataType+'_'+i+'-errors').html('<div class = "error-message">'+e.responseJSON.errors[i]+'</div');
                }
            }
        });
}

function onNotification(result) {
    if(!result || !result.data) return false;
    data = result.data;

    toastr.success(result.content, result.title);
    if(data.status == server_common.order.status.DELIVERED) {

        $('.ready_order').find('.'+result.data.id+'').remove();
        $('.delivered').prepend(data.order_table_view);
    }

    if(data.status == server_common.order.status.CUSTOMER_ORDER) {
        $('.browse_oder tbody').prepend(data.order_table_view);
    }
}

function notificationCallBack(result) {
    if(!result || !result.data) return false;
    try {
        data = JSON.parse(result.data);
    } catch(e) {
        console.error('Error JSON parse');
    }

    var clickSelector = null;

    if(data.status == server_common.order.status.DELIVERED) {
        clickSelector = $('.delivered').find('.'+data.id+'').find('.delivered-order-button');
    }

    if(data.status == server_common.order.status.CUSTOMER_ORDER) {
        clickSelector = $('.browse_oder').find('.'+data.id).find('.confirm-order');
    }

    if(clickSelector) {
        clickSelector.click()
    }

}

function approveConfirm() {
    var href = current_Selector.data('href')
    var id = current_Selector.data('id')
    if(!id) {
        id = $('#'+dataType+'_modal-delivery .order_id').val();
    }
    var data_id =  {'id': id};
    _common.request(href, data_id, { method: 'GET'})
        .then(function(res){
            location.reload();
        })
        .catch(function(err){

    });
}

function gift_process(){
    var i;
    var _line_html = [];
    for (i = 0; i < promotion_products.length; i++) {
        _line_html = _line_html.concat([
            "<div class='show_sp promotion'>"+promotion_products[i].name+"("+promotion_products[i].capacity+" kg) - x"+" 1 "+units[promotion_products[i].unit],
                "<span onclick='deleteRow(this)' class='pull-right'><i class='fa fa-times-circle'></i></span>",
                "<input type='hidden' class='form-control product_id' name= 'product_id["+promotion_products[i].id+"]' value='"+promotion_products[i].id+"' disabled>",
                "<input type='hidden' class='form-control name_sp' name= 'name_sp' value='"+promotion_products[i].name+"' disabled>",
                "<input type='hidden' class='form-control qtt_sp' name ='quantity["+promotion_products[i].id+"]' value='1' disabled>",
                "<input type='hidden' class='form-control price_sp' name ='price["+promotion_products[i].id+"]' value='"+promotion_products[i].price+"' disabled> <span class='label label-warning'>"+trans.delivery.gift.content+" </span>",
            "</div>"
        ]);
    }
    $(_line_html.join('')).insertBefore($("#create_product_id-errors"));
}
