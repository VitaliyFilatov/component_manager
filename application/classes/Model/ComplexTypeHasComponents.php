<?

class Model_ComplexTypeHasComponents extends ORM
{
    protected $_belongs_to = array(
        'complex_type'    => array(
            'model'         => 'ComplexType',
            'foreign_key' => 'complex_type_id',
        ),
        'component'    => array(
            'model'         => 'Component',
            'foreign_key' => 'component_id',
        )
    );

    protected $_table_name = "complex_type_has_components";

    public static function getComplexTypeHasComponentByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT DISTINCT cthc.id FROM complex_type_has_components AS cthc
                JOIN complex_types AS ct ON ct.id=cthc.complex_type_id
                WHERE ct.user_id=:user_id AND cthc.inner_id=:inner_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return self::factory('ComplexTypeHasComponents');
        return self::factory('ComplexTypeHasComponents', $id[0]);
    }
}


?>