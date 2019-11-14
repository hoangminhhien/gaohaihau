$(document).ready(function (event) {
    setProductUnit();

    // Select product
    $(document).on('change', '[name="product_id"]', function(){
        setProductUnit();
    });

    // Submit create inventory
    $(document).on('submit', '#create_inventory_form', function(e){
        e.preventDefault();
        var data = _common.getValueByAttr(this);
        _common.request(window.createInventoryUrl, data, { method: 'POST' })
            .then(function(res){
                location.reload();
            })
            .catch(function(){

            });

    })

    // Delete inventory confirm
    $(document).on('click', '.delete-button', function(e){
        currentSelector = $(this);
        $('#confirm_delete').modal('show');
    });
});

function setProductUnit() {
    productSelector = $('[name="product_id"]');
    var product_id = productSelector.val();
    var unit_id = productSelector.find('option[value="' + product_id + '"]').attr('unit');
    $('[name="product_unit"]').html(trans.common.products_unit_option[unit_id]);
}

function confirmDelete() {
    var href = currentSelector.data('href');
    _common.request(href, null, { method: 'POST' })
        .then(function(res){
            location.reload();
        })
        .catch(function(){

        });
}