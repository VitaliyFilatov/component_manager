<?

class Model_User extends Model_Auth_User
{
    protected $_has_many = array(
        'roles'       => array(
            'model' => 'Role',
            'through' => 'roles_users'
        ),
    );

    /**
     * @param $authUser Model_User
     * @param $userId Model_User
     * @return bool
     */
    public static function havePrivelegeOnUser($authUser, $user)
    {
        $authrole = $authUser->roles->order_by('id', 'asc')->find();
        if(!$authrole->loaded())
            return false;
        $role = $user->roles->order_by('id', 'asc')->find();
        if(!$role->loaded())
        {
            if ($authrole->name != 'manager' && $authrole->name != 'admin')
                return false;
            return true;
        }
        if ($role->id < $authrole->id)
            return false;
        if ($authrole->name != 'manager' && $authrole->name != 'admin')
            return false;
        return true;
    }

    /**
     * @param $user Model_User
     * @return Model_Role
     */
    public static function getParentUserRole($user)
    {
        return $user->roles->order_by('id', 'asc')->find();
    }
}


?>