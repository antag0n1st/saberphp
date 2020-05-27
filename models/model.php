<?php

require BASE_DIR . "lib/ClanCats/Hydrahon/Builder.php";


require BASE_DIR . "lib/ClanCats/Hydrahon/BaseQuery.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql.php";



require BASE_DIR . "lib/ClanCats/Hydrahon/TranslatorInterface.php";

require BASE_DIR . "lib/ClanCats/Hydrahon/Translator/Mysql.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Base.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Table.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/FetchableInterface.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/SelectBase.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Select.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Delete.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Update.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Truncate.php";
require BASE_DIR . "lib/ClanCats/Hydrahon/Query/Sql/Insert.php";

//require BASE_DIR."lib/Envms/FluentPDO/src/Queries/Base.php";
//
//require BASE_DIR."lib/Envms/FluentPDO/src/Query.php";
//require BASE_DIR."lib/Envms/FluentPDO/Structure.php";
//require BASE_DIR."lib/Envms/FluentPDO/Exception.php";
//require BASE_DIR."lib/Envms/FluentPDO/Literal.php";
//require BASE_DIR."lib/Envms/FluentPDO/Regex.php";
//require BASE_DIR."lib/Envms/FluentPDO/Utilities.php";

/*
 * @property Database $db
 */

class Model {

    private static $db = null;
    private static $query_builder = null;

    public function __construct() {
        
    }

    /**
     *
     * @return Database $db
     */
    public static function db() {
        if (!isset(self::$db)) {
            self::$db = new Database();
        }
        return self::$db;
    }

    // Common Database Methods
    public static function find_all($paginator = null) {

        $query = "SELECT * FROM " . static::$table_name;
        if ($paginator) {

            $paginator->total = self::count_all();
            $query = $paginator->prep_query($query);
        }

        return static::find_by_sql($query);
    }

    public static function find_by_id($id = 0) {
        $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE " . static::$id_name . "='{$id}' LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql = "") {

        $result_set = Model::db()->query($sql);
        $object_array = array();
        while ($row = Model::$db->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    public static function find_by_row($sql = "") {

        $result_set = Model::db()->query($sql);
        $object_array = array();
        while ($row = Model::$db->fetch_assoc($result_set)) {
            $object_array[] = $row;
        }

        return $object_array;
    }

    public static function join($model_name, $query = '', $limit = 0) {

        $result_set = Model::db()->query($query);

        $object_array = array();
        $id_name = static::$id_name;
        $br = 0;
        while ($row = Model::$db->fetch_array($result_set)) {

            if (end($object_array) != null) {
                if ($row[$id_name] == end($object_array)->$id_name) {
                    // use the previous instance
                    $obj = array_pop($object_array);
                } else {
                    $obj = static::instantiate($row);
                    $br++;
                }
                if ($br != 1 and $br == $limit + 1) {
                    return $object_array;
                }
            } else {
                $obj = static::instantiate($row);
                $br++;
            }



            $models_array_name = $model_name . '_';
            array_push($obj->$models_array_name, $model_name::instantiate($row));
            $object_array[] = $obj;
        }

        return $object_array;
    }

    public static function count_all() {

        $sql = "SELECT COUNT(*) FROM " . static::$table_name;
        $result_set = Model::db()->query($sql);
        $row = Model::$db->fetch_array($result_set);
        return array_shift($row);
    }

    public static function instantiate($record) {
        // Could check that $record exists and is an array
        $object = new static;

        foreach ($record as $attribute => $value) {
            if (property_exists($object, $attribute)) {
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    public function refill($record) {

        foreach ($record as $attribute => $value) {
            try {
                $this->$attribute = $value;
            } catch (Exception $exc) {
                
            }
        }

        return $this;
    }

    protected function attributes() {
        // return an array of attribute names and their values
        $attributes = array();

        foreach (static::$db_fields as $field) {

            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes() {

        $clean_attributes = array();

        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = Model::db()->prep($value);
        }
        return $clean_attributes;
    }

    public function save($ignore = false) {
        // A new record won't have an id yet.
        $id = static::$id_name;
        return (isset($this->$id) and $this->$id) ? $this->update() : $this->create($ignore);
    }

    public function create($ignore) {

        $attributes = $this->sanitized_attributes();

        $sql = "INSERT " . ( $ignore ? 'IGNORE' : '' ) . " INTO " . static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES (";

        $attrs = '';
        foreach ($attributes as $key => $value) {
            if ($key === static::$id_name) {
                $attrs .= "NULL,";
            } else if ($key === "created_at" and $value === '') {
                $this->created_at = TimeHelper::DateTimeAdjusted();
                $attrs .= "'" . $this->created_at . "',";
            } else {
                $attrs .= "'" . $value . "',";
            }
        }

        $sql .= substr($attrs, 0, -1);
        $sql .= ")";

        $sql = str_replace("'NULL'", "NULL", $sql);

        if (Model::db()->query($sql)) {
            $id = static::$id_name;
            $this->$id = Model::$db->last_inserted_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        // Don't forget your SQL syntax and good habits:
        // - UPDATE table SET key='value', key='value' WHERE condition
        // - single-quotes around all values
        // - escape all values to prevent SQL injection

        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $id = static::$id_name;
        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE " . static::$id_name . " = " . Model::db()->prep($this->$id);

        Model::db()->query($sql);
        return (Model::$db->affected_rows_count() == 1) ? true : false;
    }

    public function delete() {
        // Don't forget your SQL syntax and good habits:
        // - DELETE FROM table WHERE condition LIMIT 1
        // - escape all values to prevent SQL injection
        // - use LIMIT 1
        $id = static::$id_name;
        $sql = "DELETE FROM " . static::$table_name;
        $sql .= " WHERE " . static::$id_name . " =" . Model::db()->prep($this->$id);
        $sql .= " LIMIT 1";
        Model::db()->query($sql);
        return (Model::$db->affected_rows_count() == 1) ? true : false;

        // NB: After deleting, the instance of User still 
        // exists, even though the database entry does not.
        // This can be useful, as in:
        //   echo $user->first_name . " was deleted";
        // but, for example, we can't call $user->update() 
        // after calling $user->delete().
    }

    /**
     * 
     * @return \ClanCats\Hydrahon\Query\Sql\Table
     */
    public static function query() {

        if (self::$query_builder === null) {
            // create a new mysql query builder
            self::$query_builder = new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) {
                $queryString = preg_replace_callback('/\?/', function( $match) use( &$queryParameters) {
                    $param = array_shift($queryParameters);
                    return '\'' . Model::db()->prep($param) . '\'';
                }, $queryString);

                if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface) {
                    return self::find_by_sql($queryString);
                } else {
                    Model::db()->query($queryString);
                }
            });
        }

        return self::$query_builder->table(static::$table_name);
    }
    
    /**
     * 
     * @return \ClanCats\Hydrahon\Query\Sql\Table
     */
    public static function select($args = null) {
        return self::query()->select($args);
    }

}

?>