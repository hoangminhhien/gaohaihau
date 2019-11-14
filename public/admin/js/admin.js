$(document).ready(function () {
    // Fix for order menu
    if(window.location.pathname == '/admin/orders') {
        $('[menu_name="order"] li').removeClass('active');
        if(_common.getUrlParamByKey('status') == server_common.order.status.DELIVERED) {
            $('[menu_name="approve"]').addClass('active');
        }

        if(_common.getUrlParamByKey('status') == server_common.order.status.ARCHIVED){
            $('[menu_name="approved"]').addClass('active');
        }
    }
});