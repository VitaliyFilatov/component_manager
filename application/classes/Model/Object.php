<?

class Model_Object extends ORM
{
    protected $_belongs_to = array(
        'user'    => array(
            'model'         => 'User',
            'foreign_key' => 'user_id',
        )
    );

    public static function getObjectIdByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT id FROM objects WHERE user_id=:user_id AND inner_id=:inner_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return false;
        return $id[0];
    }

    public static function getObjectsByDeviceId($device_id)
    {
        $sql = "SELECT id FROM users WHERE device_id=:device_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':device_id', $device_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return array();
        return self::factory('Object')->where('user_id','=', $id[0])->find_all();
    }

    public static function getObjectIdsByDeviceId($device_id)
    {
        $sql = "SELECT DISTINCT o.id FROM objects AS o
                JOIN users AS u ON o.user_id=u.id
                WHERE u.device_id=:device_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':device_id', $device_id);
        return $query->execute()->as_array(NULL, 'id');
    }

}


?>