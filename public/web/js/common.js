$(document).ready(function(){
    var cookie_value = $.cookie('order');
    var items_count = cookie_value ? $.parseJSON(cookie_value).length : 0;
    $('#items-count').text(items_count);
})
