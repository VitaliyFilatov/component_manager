<?

class Model_Complex extends ORM
{
    protected $_belongs_to = array(
        'complex_type'    => array(
            'model'         => 'ComplexType',
            'foreign_key' => 'complex_type_id',
        ),
        'address'    => array(
            'model'         => 'Address',
            'foreign_key' => 'address_id',
        ),
        'room'    => array(
            'model'         => 'Room',
            'foreign_key' => 'room_id',
        )
    );

    protected $_has_many = array(
        'complex_has_components'=> array(
            'model' => 'ComplexHasComponents',
            'foreign_key' => 'complex_id',
        ),
    );


    public static function getComplexByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT DISTINCT c.id FROM complexes AS c
                JOIN complex_types AS ct ON ct.id=c.complex_type_id
                WHERE ct.user_id=:user_id AND c.inner_id=:inner_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return self::factory('Complex');
        return self::factory('Complex', $id[0]);
    }

    public static function getComplexIdByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT DISTINCT c.id FROM complexes AS c
                JOIN complex_types AS ct ON ct.id=c.complex_type_id
                WHERE ct.user_id=:user_id AND c.inner_id=:inner_id;";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return false;
        return $id[0];
    }

    public static function getComplexesByDeviceId($device_id)
    {
        $complexTypes = Model_ComplexType::getComplexTypesIdsByDeviceId($device_id);
        if(empty($complexTypes))
            return array();
        return self::factory('Complex')->where('complex_type_id','IN', $complexTypes)->find_all();
    }

}


?>