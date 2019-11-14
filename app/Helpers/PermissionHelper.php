<?php
namespace App\Helpers;
use Auth;
class PermissionHelper
{
    /**
     * Role rules config
     * allow_all: role full permission.
     * roles: Define or override some permission.
     * @return [array] List
     */
    public static function getRoleRules() {
        return [
            'allow_all' => ['9', '2', '1'],
            'roles' => [
                '2' => [
                    'admin.inventories.delete' => false,
                    'admin.projects.store' => false,
                    'admin.projects.update' => false,
                    'admin.projects.delete' => false,
                    'admin.building.edit_building' => false,
                    'admin.building.delete_building' => false,
                ],
                '1' => [
                    'admin.projects.store' => false,
                    'admin.projects.update' => false,
                    'admin.projects.delete' => false,
                    'admin.building.edit_building' => false,
                    'admin.building.delete_building' => false,
                ]
            ]
        ];
    }

    /**
     * Check permission a role
     * @param  [type]  $role   role of user
     * @param  [type]  $action route url
     * @return boolean         true if has permission
     */
    public static function hasPermission($action = "") {
        $role_rulers = PermissionHelper::getRoleRules();
        $user_role = Auth::user()['role'];
        $has_permission = false;

        // Check with allow all
        $has_permission = in_array($user_role, $role_rulers['allow_all']);

        // Check with special config
        if(isset($role_rulers['roles'][$user_role][$action])) {
            $has_permission = $role_rulers['roles'][$user_role][$action];
        }

        return $has_permission;
    }

    /**
     * Show if not has permission
     * @param  [string] $action url
     * @return [string]         style
     */
    public static function view($action = "") {
        $has_permission = PermissionHelper::hasPermission($action);
        if($has_permission) {
            return '';
        } else {
            return 'style=display:none!important';
        }
    }
}