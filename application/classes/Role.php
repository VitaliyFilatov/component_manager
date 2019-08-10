<?php defined('SYSPATH') or die('No direct script access.');

class Role  {
    
    /**
     * @param $user Model_User
     * @param $roles Model_Role[]
     */
    public static function checkUserRoles($user, &$roles)
    {
        $userRoles = $user->roles->find_all()->as_array();
        foreach($roles as $key=>&$role)
        {
            if(in_array($role, $userRoles))
            {
                $role->checked = true;
            }
        }
    }

    /**
     * @param $roleAuth Model_Role
     * @param $role Model_Role
     * @return bool
     */
    public static function havePrivelegeOnRole($roleAuth, $role)
    {
        if($roleAuth->name != 'admin' && $roleAuth->name != 'manager')
            return false;
        if($roleAuth->name == 'admin')
            return true;
        if($roleAuth->id >= $role->id)
            return false;
        return true;
    }

    /**
     * @param $user Model_User
     * @return Model_Role[]
     */
    public static function getRolesForUsersWithDisabledFlag($user, $withoutLoginRole=true)
    {
        $userRole = Model_User::getParentUserRole($user);
        $roles = ORM::factory('Role');
        if($withoutLoginRole)
        {
            $roles = $roles->where('id', '!=', 999);
        }
        $roles = $roles->find_all()->as_array();
        foreach ($roles as &$role)
        {
            $role->disabled = !self::havePrivelegeOnRole($userRole, $role);
        }
        return $roles;
    }
}