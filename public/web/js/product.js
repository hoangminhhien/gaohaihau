var max_height = 140;
var current_height = 0;
$(document).ready(function(){
    var timeout_show_modal_succes;
    $('.add-to-card-btn').on('click', function(){
        var cookie_value = $.cookie('order');
        var id = $(this).data('id');
        var quantity = $(this).data('quantity');

        if(cookie_value){
            items_count = addToCookie($.parseJSON(cookie_value), id, quantity);
        }else{
            var obj = {id : id , quantity: quantity}
            $.cookie('order', JSON.stringify([obj]), { path: '/' });
            items_count = 1;
        }
        // show add-to-cart-success
        $('#add-to-cart-success').show();
        // update items-count
        $('#items-count').text(items_count);
        timeout_show_modal_succes = window.setTimeout(function(){
            $('#add-to-cart-success').hide();
        }, 5000);
    })

    $('#add-to-cart-success-modal-close').click(function (event){
        $('#add-to-cart-success').hide();
        clearTimeout(timeout_show_modal_succes);
        event.preventDefault();
    });

        $(".product-item-desc").each(function(){
            var this_height = $(this).height();
            if (current_height < this_height && this_height < max_height ) {
                current_height = this_height;
            }
            if(this_height > max_height){
                current_height = max_height;
            }
        });
        $(".product-item-desc").css('height', current_height);

})

function addToCookie(orders, id, quantity){
    var dup = false;
    for (var i = 0; i < orders.length; i++) {
      if(orders[i].id == id){
        orders[i].quantity = orders[i].quantity+1;
        dup = true;
        break;
      }
    }

    if(!dup) {
      var obj = {id: id, quantity: quantity};
      orders.push(obj);
    }

    $.cookie('order', JSON.stringify(orders), { path: '/' });
    return orders.length;
}

