<?

class Model_Address extends ORM
{
    protected $_belongs_to = array(
        'object'    => array(
            'model'         => 'Object',
            'foreign_key' => 'object_id',
        )
    );

    public static function getAddressByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT DISTINCT a.id FROM addresses AS a
                JOIN objects AS o ON a.object_id=o.id
                WHERE o.user_id=:user_id AND a.inner_id=:inner_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return self::factory('Address');
        return self::factory('Address', $id[0]);
    }
    public static function getAddressIdByUserIdAndInnerId($user_id, $inner_id)
    {
        if($inner_id == 0)
            return null;
        $sql = "SELECT a.id FROM addresses AS a
                JOIN objects AS o ON a.object_id=o.id
                WHERE o.user_id=:user_id AND a.inner_id=:inner_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return false;
        return $id[0];
    }

    public static function getAddressesByDeviceId($device_id)
    {
        $objects = Model_Object::getObjectIdsByDeviceId($device_id);
        if(empty($objects))
            return array();
        return self::factory('Address')->where('object_id','IN', $objects)->find_all();
    }

    public static function getAddressesIdsByDeviceId($device_id)
    {
        $objects = Model_Object::getObjectIdsByDeviceId($device_id);
        if(empty($objects))
            return array();
        $sql = "SELECT DISTINCT id FROM addresses WHERE object_id IN (".implode($objects,',').");";
        $query = DB::query(Database::SELECT, $sql);
        return $query->execute()->as_array(NULL, 'id');
    }

}


?>