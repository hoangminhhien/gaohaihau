var current_href = null;
var current_selector = null;
var thisSelector;
var currentSelector = null;

$(document).ready(function (event) {
    //datepicker
    $('input[name="datetimes"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour:true,
        locale: {
          applyLabel: trans.crm.apply,
          cancelLabel: trans.crm.delete,
          format: 'DD/MM/YYYY hh:mm',
          "daysOfWeek": [
            "CN",
            "T2",
            "T3",
            "T4",
            "T5",
            "T6",
            "T7"
        ],
        "monthNames": [
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
            "Tháng 12",
          ],
        }
    });
    // New customer
    $('.new_customer_button').click(function(event){
          thisSelector = $(this);
          $('#new_customer_confirm').modal('show');
    });

    $('.cancel_new_customer_button').click(function(event){
          thisSelector = $(this);
          $('#cancel_new_customer_confirm').modal('show');
    });

    $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
          thisSelector = $(this);
          var href = thisSelector.data('href');
          data = {
            due_date : picker.startDate.format('YYYY-MM-DD HH:mm')
          }
           _common.request(href, data, { method: 'POST'})
          .then(function(res){
             toastr.success(trans.crm.edit_successfully);
                setTimeout(function(){
                },1000);
          })
          .catch(function(err){

          });
    });

    // Handle dont order 3 month
    $('.open_create_3_month').click(function(){
        current_href = $(this).data('href');
        current_selector = $(this);
        $('#confirm_create_3_month').modal('show');
    });
    $('.open_resolve_3_month').click(function(){
        current_href = $(this).data('href');
        $('#confirm_resolve_3_month').modal('show');
    });
    $('.open_cancel_3_month').click(function(){
        current_href = $(this).data('href');
        $('#confirm_cancel_3_month').modal('show');
    });

    $('.no_order_3_month_datepicker').on('apply.daterangepicker', function(ev, picker) {
        thisSelector = $(this);
        var href = thisSelector.data('href');
        data = {
           due_date : picker.startDate.format('YYYY-MM-DD HH:mm:ss')
        }
        _common.request(href, data, { method: 'POST'})
            .then(function(res){
                toastr.success(trans.crm.order_after.update_success);
            })
            .catch(function(err){

            });
    });

    // Out of rice
    $(document).on('click', '.handle_issue', function() {
        thisSelector = $(this);
        $('#confirm_handle').modal('show');
    });

    $('.cancel_out_of_rice_issue').click(function(){
        thisSelector = $(this);
        $('#cancel_out_of_rice_issue').modal('show');
    });

    $('input[name="due_date"]').on('apply.daterangepicker', function(ev, picker) {
        thisSelector = $(this);
        var href = thisSelector.data('href');
        data = {
           due_date : picker.startDate.format('YYYY-MM-DD HH:mm:ss')
        }
        _common.request(href, data, { method: 'POST'})
            .then(function(res){
                toastr.success(trans.crm.modal_out_of_rice.handle_success);
            })
            .catch(function(err){

            });
   });

    // Late customer
    $('.handle-button').click(function(){
        $('#confirm_update').modal('show');
        currentSelector = $(this);
    });
    $('.cancel-button').click(function(){
        $('#confirm_cancel').modal('show');
        currentSelector = $(this);
    });
    $('input[name="due_date_last"]').on('apply.daterangepicker', function(ev, picker) {
        thisSelector = $(this);
        var href = thisSelector.data('href');
        data = {
            due_date : picker.startDate.format('YYYY-MM-DD HH:mm:ss')
        }
        _common.request(href, data, { method: 'POST'})
            .then(function(res){
            toastr.success(trans.crm.update_successfully);
        })
        .catch(function(err){

        });
    });
});

function newCustomerConfirm() {
    var href = thisSelector.data('href');
    var data = {
      status : server_common.issue.status.RESOLVE
    }
    _common.request(href, data, { method: 'POST'})
        .then(function(res){
             toastr.success(trans.crm.issue_successfully);
                setTimeout(function(){
                    location.reload();
                },1000);
        })
        .catch(function(err){

        });
}

function CancelNewCustomerConfirm() {
    var href = thisSelector.data('href');
    var data = {
      status : server_common.issue.status.CANCEL
    }
    _common.request(href, data, { method: 'POST'})
        .then(function(res){
             toastr.success(trans.crm.delete_successfully);
                setTimeout(function(){
                    location.reload();
                },1000);
        })
        .catch(function(err){

        });
}

function handleIssueOutOfRice(){
    var href = thisSelector.data('href');
    var data = {
        status: server_common.issue.status.RESOLVE,
    };
    _common.request(href, data, { method: 'POST'})
        .then(function(res){
            toastr.success(trans.crm.modal_out_of_rice.handle_success);
            setTimeout(function(){
               location.reload();
            },1000);
        })
        .catch(function(err){

        });
}

function cancelIssueOutOfRice(){
    var href = thisSelector.data('href');
    var data = {
        status: server_common.issue.status.CANCEL,
    };
    _common.request(href, data, { method: 'POST'})
        .then(function(res){
            toastr.success(trans.crm.modal_out_of_rice.cancel_success);
            setTimeout(function(){
                location.reload();
            },1000);
         })
        .catch(function(err){

        });
}

function submitCreate3Month() {
    var data = {
        customer_id: current_selector.data('customer_id'),
        type: server_common.issue.type.NO_ORDER_3_MONTH
    };

    _common.request(current_href, data, {method: 'POST'})
        .then(function(){
            toastr.success(trans.crm.order_after.create_success);
            setTimeout(function(){
                location.reload();
            },1000);
        })
        .catch(function(e){
            console.error(e);
        });
}

function submitResolve3Month() {
    _common.request(current_href, {status: server_common.issue.status.RESOLVE}, {method: 'POST'})
        .then(function(){
            toastr.success(trans.crm.order_after.resolve_success);
            setTimeout(function(){
                location.reload();
            },1000);
        })
        .catch(function(e){
            console.error(e);
        });
}

function submitCancel3Month() {
    _common.request(current_href, {status: server_common.issue.status.CANCEL}, {method: 'POST'})
        .then(function(){
            toastr.success(trans.crm.order_after.cancel_success);
            setTimeout(function(){
                location.reload();
            },1000);
        })
        .catch(function(e){
            console.error(e);
        });
}

function confirmUpdate() {
    var href = currentSelector.data('href');
    var data = {
        status : server_common.issue.status.RESOLVE
    }
    _common.request(href, data, {method: 'POST'})
    .then(function(result){
        toastr.success(trans.crm.update_successfully);
        setTimeout(function(){
        location.reload();
      },1000);
    })
    .catch(function(error){

    });
}
function confirmCancel() {
    var href = currentSelector.data('href');
    var data = {
        status : server_common.issue.status.CANCEL
    }
    _common.request(href, data, {method: 'POST'})
    .then(function(result){
        toastr.success(trans.crm.update_successfully);
        setTimeout(function(){
        location.reload();
      },1000);
    })
    .catch(function(error){

    });
}