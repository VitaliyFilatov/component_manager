<?

class Model_User extends Model_Auth_User
{
    protected $_has_many = array(
        'roles'       => array(
            'model' => 'Role',
            'through' => 'roles_users'
        ),
    );
}


?>