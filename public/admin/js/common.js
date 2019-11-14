window._common = {
    addUrlParam: function (key, value){
        if(!value) value = '';
        key = encodeURI(key); value = encodeURI(value);

        var kvp = document.location.search.substr(1).split('&');

        var i = kvp.length; var x; while(i--) 
        {
            x = kvp[i].split('=');

            if (x[0]==key)
            {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if(i<0) {
            kvp[kvp.length] = [key,value].join('=');
        }

        var str = ""
        if(!kvp[0]) {
          str = kvp.join('');
        } else {
          str = kvp.join('&');
        }
        document.location.search = str;
    },
    getUrlParamByKey: function(key) {
        var listParams = {};
        var kvp = document.location.search.substr(1).split('&');
        var i, child;

        for(i in kvp) {
            child = kvp[i].split('=');
            if(child.length >=2) {
                listParams[child[0]] = child[1];
            }
        }
        return listParams[key];
    },
    getAllUrlParams: function () {
        var listParams = {};
        var kvp = document.location.search.substr(1).split('&');
        var i, child;

        for(i in kvp) {
            child = kvp[i].split('=');
            if(child.length >=2) {
                listParams[child[0]] = child[1];
            }
        }
        return listParams;
    },
    convertToUrlParams: function(obj, encode) {
        var str = "", i;
        for(i in obj) {
            if(str) str += "&";
            str += i + "=" + obj[i];
        }
        if(encode) {
            str = encodeURI(str);
        }
        return str;
    },
    randomNumber: function() {
        return Math.floor(new Date().getTime() / 1000).toString() + Math.floor(Math.random() * (9999-1000) + 1000);
    },
    request: function(url, data, option) {
        if(!option) option = {};
        if(!data) data = {};
        if(option.use_loading) {
            $('loading').show();
            delete option.use_loading;
        }

        // block submit button
        $('.submit-button').prop('disabled', true);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        return new Promise(function(resolve, reject){
            var ajaxRequest = {
                headers: {},
                type: (option.method || "get").toLowerCase(),
                url: url,
                data: data,
                success: function(response){
                    $('loading').hide();
                    $('.submit-button').prop('disabled', false);
                    return resolve(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR) {
                        jqXHR.textStatus = textStatus;
                        jqXHR.errorThrown = errorThrown;
                    }
                    _common.showErrorMessage(jqXHR);
                    $('loading').hide();
                    $('.submit-button').prop('disabled', false);
                    return reject(jqXHR);
                }
            }

            var i;
            for(i in option) {
                ajaxRequest[i] = option[i];
            }

            $.ajax(ajaxRequest);
        });
    },
    removeComma: function(data) {
        if(!data) data = "";
        return data.replace(/,/g, '');
    },
    numberWithCommas: function(x) {
        if(!x) x = 0;
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    removeArrayItem: function(value, array) {
        var index = array.indexOf(value);
        if (index > -1) {
            array.splice(index, 1);
        }
        return array;
    },
    showErrorMessage: function (jqXHR) {
        var obj = JSON.parse(jqXHR.responseText)['errors'];
        var key;
        $('.error-message').empty();
        for (key in obj) {
            $('.' + key + '-errors').html('<div class="error-message">' + obj[key].join('. ') + '</div');
        }
        setTimeout(function () {
            $('.error-message').hide();
        }, 3000);
    },
    getValueByAttr(selector, attr){
        var data = {};

        if(!selector) selector = 'form';
        if(!attr) attr = 'name';

        var thisSelector = $(selector);
        thisSelector.find('[' + attr + ']').each(function(){
            var thisSelectorAfterFind = $(this);
            data[thisSelectorAfterFind.attr(attr)] = thisSelectorAfterFind.val();
        });
        return data;
    },
    addInputMaskCurrency: function(selector) {
        $(selector).inputmask({
            'alias': 'decimal',
            'groupSeparator': ',',
            'autoGroup': true,
            'removeMaskOnSubmit': true,
            'autoUnmask': true,
            'suffix': ' ₫',
            'allowMinus': false
        });
    },
    formatCurrency: function(data) {
        if(!data) data = 0;
        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' ₫';
      },
    readUploadImage: function(files, selector) {
        if(!files || !files[0]) {
            return false;
        }

        files = files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var result = e.target.result;
            $(selector).css({
                'background': 'url(' + result + ')',
                'background-repeat': 'no-repeat',
                'background-position': 'center',
                'background-size': 'contain'
            });
        }
        reader.readAsDataURL(files);
    },
    getCookie: function(key, dataType) {
        var cookie_value = $.cookie(key);

        if(!cookie_value) return cookie_value;

        switch(dataType) {
            case 'object':
                try {
                    cookie_value = JSON.parse(cookie_value);
                } catch(e) {
                    cookie_value = [];
                }
            break;
        }
        return cookie_value;
    }
};

var block_hour = [];

$(document).ready(function(){
    moment.suppressDeprecationWarnings = true;
    /* Daterange pick */
    $('.common-datepicker').each(function(e){
        var thisSelector = $(this);
        thisSelector.attr("autocomplete", "off");
        var option = {
            singleDatePicker: true,
            cancelButtonClasses: true,
            drops: "down",
            'autoApply': true,
            locale: {
                format: 'DD/MM/YYYY',
                daysOfWeek: [
                    "CN",
                    "T2",
                    "T3",
                    "T4",
                    "T5",
                    "T6",
                    "T7"
                ],
                monthNames: [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"
                ]
            },
            autoUpdateInput: false
        };
        var format = thisSelector.attr('format');
        if(format) option.locale.format = format;

        var value = thisSelector.val();
        if(value) thisSelector.val(moment(value).format(option.locale.format));

        var min_date = thisSelector.attr('min_date');
        var max_date = thisSelector.attr('max_date');
        if(min_date) option.minDate = moment(min_date);
        if(max_date) option.maxDate = moment(max_date);

        // with date range
        var range_type = thisSelector.attr('range_type');
        if(range_type) {
            var start_date = thisSelector.attr('start_date');
            var end_date = thisSelector.attr('end_date');
            option.singleDatePicker = false;
            if(start_date) option.startDate = moment(start_date);
            if(end_date) option.endDate = moment(end_date);
        }
        //drops
        var open_drop = thisSelector.attr('open_drop');

        if(open_drop){
            option.drops = open_drop
        }
        // time
        var time = !!thisSelector.attr('time');
        var time_24h = !!thisSelector.attr('time_24h')
        var minute_step = thisSelector.attr('minute_step')
        var applyButton = thisSelector.attr('applyButton')
        var cancelButton = thisSelector.attr('cancelButton')
        if(time) {
            option.timePicker = time;
            if(time_24h) option.timePicker24Hour = time_24h;
        }
        if(minute_step) {
            option.timePickerIncrement = parseInt(minute_step);
        }
        if(applyButton) {
            option.locale.applyLabel = applyButton
        }
        if(cancelButton) {
            option.locale.cancelLabel = cancelButton
        }
        thisSelector.daterangepicker(option,function(date) {
            thisSelector.val(date.format(option.locale.format));
        });
    });

    /* block ui */
    // remove block ui
    $('loading').hide();
    // add block ui
    $('.click-to-loading').click(function(){
        $('loading').show();
    });

    // Toastr
    $('.toastr-success').each(function(){
        var thisSelector = $(this);
        var title = thisSelector.attr('title') || 'Thông báo';
        var content = thisSelector.attr('content') || "Thành công";
        toastr.success(content, title);
    });

    $('.toastr-error').each(function(){
        var thisSelector = $(this);
        var title = thisSelector.attr('title') || 'Thông báo';
        var content = thisSelector.attr('content') || "Thất bại";
        toastr.error(content, title);
    });

    /* Mask */
    // Currency
    $(document).find('.common-currency').inputmask({
        'alias': 'decimal',
        'groupSeparator': ',',
        'autoGroup': true,
        'removeMaskOnSubmit': true,
        'autoUnmask': true,
        'suffix': ' ₫',
        'allowMinus': false
    });
    $(document).find('.common-capacity').inputmask({
        'alias': 'decimal',
        'groupSeparator': ',',
        'autoGroup': true,
        'removeMaskOnSubmit': true,
        'autoUnmask': true,
        'suffix': ' kg',
        'allowMinus': false
    });
    // Phone
    $(document).find('.common-number').inputmask({
        'mask': '999 999 9999 [99999]',
        'groupSeparator': ',',
        'autoGroup': true,
        'removeMaskOnSubmit': true,
        'autoUnmask': true,
        'greedy': false 
    });

    // number
    $(document).find('.common-numeric').inputmask({
        'alias': 'decimal',
        'groupSeparator': ',',
        'autoGroup': true,
        'removeMaskOnSubmit': true,
        'autoUnmask': true,
        'allowMinus': false
    });

    $(document).on('click', '.delivery_time', function(){
        var thisSelector = $(this);
        var delivery_time = thisSelector.attr('block-hour');
        var result = delivery_time.split(',');
        block_hour = result
    });

    // Custopm daterangepicker
    $(document).on('focus', '.hourselect', function(){
        for(i in block_hour){
            $('.hourselect option[value='+block_hour[i]+']').hide();
        }
    });

    // scroll to load
    $(".common-loadmore").scroll(function() {
        var thisSelector = $(this);
        var contentSelector = thisSelector.find('.common-loadmore-content');
        var onloadmore = thisSelector.attr('onloadmore');
        var heightOffset = parseInt(thisSelector.attr('height-offset')) || 0;
        var event = thisSelector.attr('event');
        if ((thisSelector.scrollTop() + thisSelector.height()) == (contentSelector.height() + heightOffset)) {
            thisSelector.trigger(event);
        }
    });

    // Init select-2
    $(".select2").each(function(){
        var thisSelector = $(this);
        var option = {};

        var disable_search = thisSelector.attr('disable_search');
        if(disable_search) {
            option.minimumResultsForSearch = -1;
        }

        thisSelector.select2(option);
    });
})

function changeOrderDataInCookie(id, quantity, replaceOldQuantity) {
    var orders = _common.getCookie('order', 'object');
    var dup = false;
    var i;

    if(!id) {
        console.error('Wrong ID');
        return false;
    }

    if(isNaN(quantity)) {
        quantity = 1;
    }

    for (i = 0; i < orders.length; i++) {
        if(orders[i] && orders[i].id == id){
            if(quantity == 0) {
                orders.splice(i, 1);
            } else {
                orders[i].quantity = orders[i].quantity + quantity;
                if(replaceOldQuantity) {
                    orders[i].quantity = quantity;
                }
            }
            dup = true;
            break;
        }
    }

    if(!dup) {
        var obj = {id: id, quantity: quantity};
        orders.push(obj);
    }

    $.cookie('order', JSON.stringify(orders), { path: '/' });
    return false;
}
