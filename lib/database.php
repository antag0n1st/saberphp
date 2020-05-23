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
    
    private $search = array("\x00","\\", "'", "\"", "\x1a");
    private $replace = array("\\x00","\\\\", "\'", "\\\"", "\\\x1a");

    public function __construct() {
        $this->open_connection();
        
        if(HOST_ID !== 0){
            $this->query('set global SQL_MODE="NO_ENGINE_SUBSTITUTION"');
        }
        
    }
    
    public function __destruct() {
        $this->close_connection();
    }
    
    private function open_connection() {
        if (!Database::$con) {
            Database::$con = mysqli_connect($this->hostname, $this->username, $this->password);
            if (!Database::$con) {
				die('Could not connect to Database');
                // die('Could not connect: ' . mysqli_error(Database::$con));
            }
            mysqli_select_db(Database::$con,$this->dbname);
            mysqli_query(Database::$con,"SET NAMES 'utf8'");
        }
    }
    /**
     * Changes the database used
     * @param type $db_name 
     */
    public function change_db($db_name){
        mysqli_select_db(Database::$con,$db_name);
    }
    /**
     * It reverts the connection to the default database used 
     */
    public function change_db_to_default(){
        mysqli_select_db(Database::$con,$this->dbname);
    }
    
    private function close_connection() {
        if (!Database::$con) {
            mysqli_close(Database::$con);
            Database::$con = null;
        }
    }
    /**
     * mysql_fetch_array wrapper
     * @param resource $result
     * @return array 
     */
    public function fetch_array($result) {
        return mysqli_fetch_array($result);
    }
    /**
     * mysql_fetch_assoc wrapper
     * @param type $result
     * @return array 
     */
    public function fetch_assoc($result) {
        return mysqli_fetch_assoc($result);
    }
    
    public function fetch_object($result) {
        return mysqli_fetch_object($result);
    }

    private function execute() {
        $this->open_connection();
        $msc = microtime(true);
        $this->result = mysqli_query(Database::$con,$this->sql) or die("MySQL ERROR: " . mysqli_error(Database::$con) . " QUERY: " . $this->sql);
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
        $this->mysql_affected_rows = mysqli_affected_rows(Database::$con);

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
        return mysqli_insert_id(Database::$con);
    }
    /**
     * Prevents SQL Injection
     * @param type $value
     * @return type 
     */
    public function prep($value) {

        

        return str_replace($this->search, $this->replace, $value);
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