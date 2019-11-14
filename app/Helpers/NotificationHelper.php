<?php
namespace App\Helpers;
use Auth;
class NotificationHelper
{
    /**
     * customer_order, confirmed_order...: Event name, to call in controller.
     * object_type: Object save to database
     * event: Event class to push
     * to_condition: condition to push(id, role...)
     * Type: notification type: 1. Info. 2. Warning, 3. Error
     */
    const EVENTS = [
        'customer_order' => [
            'object_type' => 'orders',
            'event' => '\App\Events\OrderEvent',
            'to_condition' => ['role' => [2,9]], // Điều kiện để push
            'type' => 1,
        ],
        'confirmed_order' => [
            'object_type' => 'orders',
            'event' => '\App\Events\OrderEvent',
            'to_condition' => [],
            'type' => 2,
        ],
        'confirmed_order_to_shipper' => [
            'object_type' => 'orders',
            'event' => '\App\Events\OrderEvent',
            'to_condition' => [],
            'type' => 1,
        ],
        'canceled_order' => [
            'object_type' => 'orders',
            'event' => '\App\Events\OrderEvent',
            'to_condition' => [],
            'type' => 3,
        ],
        'delivered_order' => [
            'object_type' => 'orders',
            'event' => '\App\Events\OrderEvent',
            'to_condition' => ['role' => [2,9]],
            'type' => 1,
        ],
    ];

    /**
     * Push notification
     * @param  [type] $options
     * @return [type]                 true
     */
    public static function pushNotification($options = []) {
        // Define variable
        $event = null;
        $data = [];
        $content_params = [];
        $to_condition = [];
        $db_data_column = null;

        if(isset($options['event'])) {
            $event = $options['event'];
        }
        if(isset($options['data'])) {
            $data = $options['data'];
        }
        if(isset($options['content_params'])) {
            $content_params = $options['content_params'];
        }
        if(isset($options['to_condition'])) {
            $to_condition = $options['to_condition'];
        }
        if(isset($options['db_data_column'])) {
            $db_data_column = $options['db_data_column'];
        }

        // Validate
        if(!$event || empty(NotificationHelper::EVENTS[$event])) {
            throw new \Exception("\$event is not exist! Please check const NotificationHelper::EVENTS");
        }

        $event_data = [];
        $event_data['title'] = trans('notification.' . $event . '.title');
        $event_data['content'] = \CommonHelper::replaceParamsInText(trans('notification.' . $event . '.content'), $content_params);
        $event_data['data'] = $data;

        if(strrpos($event_data['content'], '{$') !== false) {
            throw new \Exception("Content params is not correct. You must replace all params in content message. Current content message after replace: \"" . $event_data['content'] . "\"");
        }

        $event_object = NotificationHelper::EVENTS[$event];

        // Get broardcast user
        $user_query = \App\User::select('*');
        $to_condition = array_merge($to_condition, $event_object['to_condition']);
        if(!empty($to_condition)) {
            foreach ($to_condition as $key => $value) {
                if(gettype($value) === 'array') {
                    $user_query = $user_query->whereIn($key, $value);
                } else {
                    $user_query = $user_query->where($key, $value);
                }
            }
        }

        $user = Auth::user();
        if($user) {
            $user_query = $user_query->where('id', '!=', $user->id);
        }

        $user_list = $user_query->get();

        foreach ($user_list as $value) {
            // Handle save data
            $event_data['to_id'] = $value['id'];
            $event_data['type'] = $event_object['type'];
            $event_data['object_type'] = $event_object['object_type'];
            $save_data = $event_data;

            if(!empty($db_data_column)) {
                $save_data['data'] = $db_data_column;
            }

            if(gettype($save_data['data']) === 'array') {
                $save_data['data'] = json_encode($save_data['data']);
            }

            // Create notification
            $result = \App\Models\Notification::create($save_data);

            // Push notification
            $event_data['created_data'] = $result;
            broadcast(new $event_object['event']($event_data));
        }

        return true;
    }
}