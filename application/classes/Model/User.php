<?

class Model_User extends ORM
{
    public static function insertIfNotExist($device_id)
    {
        $sql = "INSERT INTO users (device_id) 
                SELECT :device_id FROM DUAL
                  WHERE NOT EXISTS (SELECT * FROM users 
                  WHERE device_id=:device_id);";
        $query = DB::query(Database::INSERT, $sql);
        $query->param(':device_id', $device_id);
        $query->execute();
    }


}


?>