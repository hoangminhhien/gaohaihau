<?php
namespace App\Helpers;
use Request;
class MenuHelper
{
    public static function isMenuActive($menu_item) {
        $current_path = Request::getPathInfo();

        if(strpos($current_path . '/', $menu_item['url'] . '/') !== false) {
            return true;
        }

        if(!empty($menu_item['submenu'])) {
            $not_active = true;
            foreach ($menu_item['submenu'] as $value) {
                if(strpos($current_path . '/', $value['url'] . '/') !== false) {
                    $not_active = false;
                    break;
                }
            }
            if(!$not_active) {
                return true;
            }
        }

        return false;
    }

    public static function generateUrlFromMenu($menu_item) {
        $url = 'javascript:void(0)';
        if(empty($menu_item['submenu']) && !empty($menu_item['url'])) {
            $url = $menu_item['url'];
        }
        if(!empty($menu_item['params'])) {
            $url .= '?';
            foreach ($menu_item['params'] as $key => $value) {
                $url .= $key . '=' . $value;
            }
        }

        return $url;
    }
}