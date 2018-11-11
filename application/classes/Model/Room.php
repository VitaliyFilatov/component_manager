<?

class Model_Room extends ORM
{
    protected $_belongs_to = array(
        'address'    => array(
            'model'         => 'Address',
            'foreign_key' => 'address_id',
        )
    );

    public static function getRoomByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT DISTINCT r.id FROM rooms AS r
                JOIN addresses AS a ON r.address_id=a.id
                JOIN objects AS o ON o.id=a.object_id
                WHERE o.user_id=:user_id AND r.inner_id=:inner_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return self::factory('Room');
        return self::factory('Room', $id[0]);
    }

    public static function getRoomIdByUserIdAndInnerId($user_id, $inner_id)
    {
        if($inner_id == 0)
            return null;
        $sql = "SELECT DISTINCT r.id FROM rooms AS r
                JOIN addresses AS a ON r.address_id=a.id
                JOIN objects AS o ON o.id=a.object_id
                WHERE o.user_id=:user_id AND r.inner_id=:inner_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return false;
        return $id[0];
    }

    public static function getRoomsByDeviceId($device_id)
    {
        $addresses = Model_Address::getAddressesIdsByDeviceId($device_id);
        if(empty($addresses))
            return array();
        return self::factory('Room')->where('address_id','IN', $addresses)->find_all();
    }
}


?>