<?

class Model_ComplexHasComponents extends ORM
{
    protected $_belongs_to = array(
        'complex'    => array(
            'model'         => 'Complex',
            'foreign_key' => 'complex_id',
        ),
        'component'    => array(
            'model'         => 'Component',
            'foreign_key' => 'component_id',
        )
    );

    protected $_table_name = "complex_has_components";

    public static function getComplexHasComponentByUserIdAndInnerId($user_id, $inner_id)
    {
        $sql = "SELECT DISTINCT chc.id FROM complex_has_components AS chc
                JOIN components AS c ON c.id=chc.component_id
                WHERE c.user_id=:user_id AND chc.inner_id=:inner_id";
        $query = DB::query(Database::SELECT, $sql);
        $query->param(':user_id', $user_id);
        $query->param(':inner_id', $inner_id);
        $id = $query->execute()->as_array(NULL, 'id');
        if(empty($id))
            return self::factory('ComplexHasComponents');
        return self::factory('ComplexHasComponents', $id[0]);
    }

    public static function getComplexHasComponentsByComplexTypeId($complexTypeId)
    {
        return self::factory('ComplexHasComponents')->where('complex_type_id','=',$complexTypeId);
    }

}


?>