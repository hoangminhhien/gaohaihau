var notificationState = {
    last_id: 0,
    out_of_data: false,
    isRequest: false,
    unread: 0,
    data: [],
    getNotificationFromServer: function() {
        if(notificationState.isRequest) {
            return false;
        }

        if(notificationState.out_of_data) {
            return false;
        }

        $('spinner').show();
        notificationState.isRequest = true;
        var data = {
            last_id: notificationState.last_id
        };

        _common.request(getNotificationUrl, data)
            .then(function(res){
                $('spinner').hide();
                if(!res['data'].length) {
                    notificationState.out_of_data = true;
                    return false;
                }
                // Build notification
                notificationState.data = notificationState.data.concat(res['data']);
                notificationState.buildTemplate(res);

                notificationState.unread = res['unread'];
                notificationState.buildReadNumber();

                notificationState.isRequest = false;
            })
            .catch(function(e){
                notificationState.isRequest = false;
                $('spinner').hide();
            });
    },
    buildTemplate: function(res, add_type) {
        var i, tmp = [], data = res['data'];
        for(i in data) {
            tmp.push('<li data-id="' + data[i].id + '" onclick="notificationState.onRead(this)" class="');
            if(!data[i]['is_read']) {
                tmp.push('unread-notification');
            }
            tmp.push('">');
            tmp.push('<a href="javascript:void(0)">');
                tmp.push('<div class="notification-title">')
                    tmp.push('<i class="' + server_common['notification']['icon_by_type'][data[i]['type']] + '"></i> ');
                    tmp.push(data[i].title);
                tmp.push('</div>');
                tmp.push('<div class="notification-content">');
                    tmp.push(data[i]['content']);
                tmp.push('</div>');
                tmp.push('<div class="notification-date">')
                    tmp.push('<i class="fa fa-clock-o"></i> ');
                    tmp.push(moment(data[i].created_at).format('DD/MM/YYYY HH:mm'));
                tmp.push('</div>');
                tmp.push('</a>');
            tmp.push('</li>');

            if(!notificationState.last_id || data[i].id < notificationState.last_id) {
                notificationState.last_id = data[i].id;
            }
        }
        if(add_type === 'prepend') {
            $('.notification-menu .menu').prepend(tmp.join(''));
        } else {
            $('.notification-menu .menu').append(tmp.join(''));
        }
    },
    buildReadNumber: function() {
        $('.notification-unread-count').html(notificationState.unread);
        if(notificationState.unread) {
            $('.notification-unread-count').show();
        } else {
            $('.notification-unread-count').hide();
        }
    },
    onRead: function(thisSelector) {
        thisSelector = $(thisSelector);
        var id = thisSelector.data('id');
        // Callback when click notification
        if(typeof notificationCallBack == 'function') {
            var i, notificationData = {};
            for(i in notificationState.data) {
                if(notificationState.data[i].id == id) {
                    notificationData = notificationState.data[i];
                }
            }
            notificationCallBack(notificationData);
        }

        if(thisSelector.hasClass('unread-notification')) {
            thisSelector.removeClass('unread-notification');
            notificationState.unread -= 1;
            notificationState.buildReadNumber();
        } else {
            return false;
        }


        // Request
        _common.request(readNotificationUrl, { id: id }, {method: 'POST'})
            .then(function(res){
            })
            .catch(function(e){

            });
    },
    onReadAll: function() {
        $('.unread-notification').removeClass('unread-notification');
        notificationState.unread  = 0;
        notificationState.buildReadNumber();
        _common.request(readNotificationUrl, null, {method: 'POST'})
            .then(function(res){

            })
            .catch(function(e){

            });
    },
    newNotification: function(data) {
        notificationState.data.push(data['created_data']);
        notificationState.buildTemplate({data: [data['created_data']]}, 'prepend');
        notificationState.unread += 1;
        notificationState.buildReadNumber();
    },
    showMessage: function(data) {
        switch(data.type) {
            case 1:
                toastr.success(data.content, data.title);
                break;
            case 2:
                toastr.warning(data.content, data.title);
                break;
            case 3:
                toastr.error(data.content, data.title);
                break;
            default:
                toastr.success(data.content, data.title);
        }
    }
};

$(document).ready(function(){
    $('.common-loadmore').on('loadmore-notification', function(){
        notificationState.getNotificationFromServer();
    });
    notificationState.getNotificationFromServer();
});
var socket_host = location.origin;
if(server_common.custom_port) {
    socket_host = location.hostname + ":" + server_common.custom_port;
}

window.Echo = new Echo({
    namespace: 'App.Events',
    broadcaster: 'socket.io',
    host: socket_host,
    auth: {
        headers: {
            'Cookie': document.cookie
        }
    },
});

// Listen Role channel
window.Echo.private('User.' + $user.id)
    .listen('OrderEvent', (data) => {
        notificationState.newNotification(data);
        if(typeof onNotification == 'function') {
            onNotification(data);
        }
        // notificationState.showMessage(data);
    });