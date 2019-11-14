<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu notification-dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span></span>
        <span class="label label-warning notification-unread-count"></span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a class="read-all" onclick="notificationState.onReadAll()">
                <i class="fa fa-check m-0-i"></i> {{ trans('partials.notification.read_all') }}
            </a>
        </li>
        <li class="notification-menu common-loadmore" event="loadmore-notification" height-offset="20">
            <ul class="menu common-loadmore-content">
                <li>
            </ul>
            <div class="h-20p">@include('admin.partials.spinner')</div>
        </li>
    </ul>
</li>
@section('notification_javascript')
<script type="text/javascript">
    @php
        echo 'window.getNotificationUrl = "' . route('admin.notifications.getJsonList') . '";';
        echo 'window.readNotificationUrl = "' . route('admin.notifications.readNotification') . '";';
    @endphp
</script>
<script src="{{asset('admin/js/notification.js')}}"></script>
@stop