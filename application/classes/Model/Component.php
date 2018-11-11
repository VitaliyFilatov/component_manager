<?

class Model_Component extends ORM
{
    protected $_belongs_to = array(
        'user'    => array(
            'model'         => 'User',
            'foreign_key' => 'user_id',
        )
    );

    public static function getComponentIdByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT id FROM components
                WHERE components.user_id=:user_id AND components.inner_id=:inner_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return false;
        return $id[0];
    }

    public static function getComponentsByDeviceId($device_id)
    {
        $sql = "SELECT id FROM users WHERE device_id=:device_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':device_id', $device_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return array();
        return self::factory('Component')->where('user_id','=', $id[0])->find_all();
    }
}


?>