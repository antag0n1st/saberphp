<?php
/**
 * The database object 
 * @author Antagonist
 */
class Database {

    private $hostname = DB_SERVER;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;
    private static $con = null;
    private $sql;
    public $result;
    public $mysql_affected_rows = -2;
    private static $queries = array();

    public function __construct() {
        $this->open_connection();
    }
    
    public function __destruct() {
        $this->close_connection();
    }
    
    private function open_connection() {
        if (!Database::$con) {
            Database::$con = mysql_connect($this->hostname, $this->username, $this->password);
            if (!Database::$con) {
                die('Could not connect: ' . mysql_error());
            }
            mysql_select_db($this->dbname, Database::$con);
            mysql_query("SET NAMES 'utf8'");
        }
    }
    /**
     * Changes the database used
     * @param type $db_name 
     */
    public function change_db($db_name){
        mysql_select_db($db_name, Database::$con);
    }
    /**
     * It reverts the connection to the default database used 
     */
    public function change_db_to_default(){
        mysql_select_db($this->dbname, Database::$con);
    }
    
    private function close_connection() {
        if (!Database::$con) {
            mysql_close(Database::$con);
            Database::$con = null;
        }
    }
    /**
     * mysql_fetch_array wrapper
     * @param resource $result
     * @return array 
     */
    public function fetch_array($result) {
        return mysql_fetch_array($result);
    }
    /**
     * mysql_fetch_assoc wrapper
     * @param type $result
     * @return array 
     */
    public function fetch_assoc($result) {
        return mysql_fetch_assoc($result);
    }

    private function execute() {
        $this->open_connection();
        $msc = microtime(true);
        $this->result = mysql_query($this->sql) or die("MySQL ERROR: " . mysql_error() . " QUERY: " . $this->sql);
        $msc = microtime(true) - $msc;
        self::$queries[] = array('query' => $this->sql, 'time' => $msc);
    }
    /**
     * executes query and returns result
     * @param type $query
     * @return type 
     */
    public function query($query) {
        if (Database::$con == null) {
            $this->open_connection();
        }
        $this->sql = $query;
        $this->execute();
        $this->mysql_affected_rows = mysql_affected_rows();

        return $this->result;
    }
    /**
     * Executes the query and returns the first row
     * @param type $query
     * @return type 
     */
    public function query_first_row($query){
        $this->query($query);
        return $this->result ? $this->fetch_array($this->result) : false;
    }
    /**
     * The number of affected rows from the last query executed
     * @return int 
     */
    public function affected_rows_count() {
        return $this->mysql_affected_rows;
    }
    /**
     * mysql_insert_id wrapper
     * @return type 
     */
    public function last_inserted_id() {
        return mysql_insert_id();
    }
    /**
     * Prevents SQL Injection
     * @param type $value
     * @return type 
     */
    public function prep($value) {

        $search = array("\x00", "\n", "\r", "\\", "'", "\"", "\x1a");
        $replace = array("\\x00", "\\n", "\\r", "\\\\", "\'", "\\\"", "\\\x1a");

        return str_replace($search, $replace, $value);
    }
    /**
     * Returns all the queries logged 
     * @return type 
     */
    public static function get_info() {
        return self::$queries;
    }

}

?>