<?

class Model_ComplexType extends ORM
{
    protected $_belongs_to = array(
        'user'    => array(
            'model'         => 'User',
            'foreign_key' => 'user_id',
        )
    );

    protected $_has_many = array(
        'complex_type_has_components'=> array(
            'model' => 'ComplexTypeHasComponents',
            'foreign_key' => 'complex_type_id',
        ),
    );


    protected $_table_name = "complex_types";

    public static function getComplexTypeIdByUserIdAndInnerId($user_id, $inner_id)
    {
        if($inner_id == 0)
            return null;
        $sql = "SELECT id FROM complex_types
                WHERE complex_types.user_id=:user_id AND complex_types.inner_id=:inner_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return false;
        return $id[0];
    }

    public static function getComplexTypesByDeviceId($device_id)
    {
        $sql = "SELECT id FROM users WHERE device_id=:device_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':device_id', $device_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return array();
        return self::factory('ComplexType')->where('user_id','=', $id[0])->find_all();
    }

    public static function getComplexTypesIdsByDeviceId($device_id)
    {
        $sql = "SELECT DISTINCT ct.id FROM complex_types AS ct
                JOIN users AS u ON u.id=ct.user_id
                WHERE u.device_id=:device_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':device_id', $device_id);
        return $query->execute()->as_array(NULL, 'id');
    }
}


?>