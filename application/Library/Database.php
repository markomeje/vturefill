<?php

namespace VTURefill\Library;
use VTURefill\Core\Logger;
use \Exception;
use \PDO;

class Database {
    
    /**
     * @access private
     * @var PDO PDO Object [default = null]
     */
    private $pdo = null;

    /**
     * @access private
     * @var PDOStatement PDOStatement Object
     */
    private $statement = null;

    /**
     * @access private
     * @static static
     * 
     * @var Database Database Object used to implement the Singleton pattern
     */
    private static $instance = null;

     /**
      * Database Constructor for instant connection
      *
      * @return object
      * 
      */
    public function __construct() {
        try{ 
            if (SERVER_HTTPS === false) {
                $connect = 'mysql:dbname='.LOCAL_DATABASE_NAME.';host='.LOCAL_DATABASE_HOST.';charset='.LOCAL_DATABASE_CHARSET;
                $this->pdo = new PDO($connect, LOCAL_DATABASE_USERNAME, LOCAL_DATABASE_PASSWORD);
            }else {
                $connect = 'mysql:dbname='.LIVE_DATABASE_NAME.';host='.LIVE_DATABASE_HOST.';charset='.LIVE_DATABASE_CHARSET;
                $this->pdo = new PDO($connect, LIVE_DATABASE_USERNAME, LIVE_DATABASE_PASSWORD);
            }
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }catch(Exception $error) {
            Logger::log("DATABASE CONNECTION ERROR", $error->getMessage(), __FILE__, __LINE__);
            return false;
        }
    }

    /**
     * Singleton design pattern - It creates the database instance once and reuses it
     *
     * @return database object [PDO]
     * @access public
     * @static static method
     * 
     */
    public static function connect() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Prepares a SQL query for execution and assign a statement object to $this->statement
     *
     * @access public
     * @param  string  $query
     *
     */
    public function prepare($query) {
        $this->statement = $this->pdo->prepare($query);
        return $this;
    }
    
    /**
     * Binds a value to a parameter.
     *
     * A better practice to explicitly define data types in parameter declarations,
     * So, instead of defining the data type parameter every time,
     * Just pass the value, and getPDOType() will take care of it's data type
     *
     * @access public
     * @param   string  $param
     * @param   mixed   $value
     *
     */
    public function bindValue($holder, $value) {
        $type = self::getPDOType($value);
        return $this->statement->bindValue($holder, $value, $type);
    }
    
    /**
     * Executes a prepared statement
     *
     * @access public
     * @param array Array of values to be bound in SQL query, All values are treated as PDO::PARAM_STR.
     * @return boolean Returns TRUE on success or FALSE on failure.
     *
     */
    public function execute($array = []){
        return empty($array) ? $this->statement->execute() : $this->statement->execute($array);
    }

    /**
     * Start a transaction
     *
     * @access public
     * @return  boolean [TRUE on success or FALSE on failure.]
     * 
     */
    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    /**
     * Commits a transaction
     * @return [boolean] [TRUE on success or FALSE on failure.]
     */
    public function commit() {
        $this->pdo->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by PDO::beginTransaction().
     * A PDOException will be thrown if no transaction is active.
     * 
     * @return [boolean] [It will return the database connection to autocommit 
     * mode until the next call to PDO::beginTransaction() starts a new transaction.]
     */
    public function rollBack() {
        $this->pdo->rollBack();
    }

    /**
     * To fetch the result data in form of [0-indexed][key][value] array.
     *
     * @access public
     * @return array empty array if no data returned
     */
    public function fetchAll() {
        return $this->statement->fetchAll();
    }
    
    /**
     * To fetch Only the next row from the result data in form of [key][value] array.
     *
     * @access public
     * @return array or bool-False on if no data returned
     */
    public function fetch() {
        return $this->statement->fetch();
    }
    
    /**
     * Returns the id of the last inserted row
     *
     * @access public
     * @return integer-The ID of the last inserted row of Auto-incremented primary key.
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Returns the number of rows affected by the last SQL statement
     *
     * @access public
     */
    public function rowCount() {
        return $this->statement->rowCount();
    }
    
    /**
     * Determine the PDOType of a passed value.
     * This is done by determining the data type of the passed value.
     *
     * @access public
     * @param  mixed  $value
     * @return PDO Constants
     *
     */
    private static function getPDOType($value){
        switch ($value) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            case is_float($value):
                return PDO::PARAM_STR;
            default:
                return PDO::PARAM_STR;
        }
    }
    
    /**
     * Closing the connection.
     *
     * It's not necessary to close the connection, however it's a good practice.
     * "If you don't do this explicitly, PHP will automatically close the connection when your script ends."
     *
     * This will be used at the end "footer.php"
     *
     * @static static method
     * @access public
     */
    public static function disconnect() {
        if(isset(self::$instance)) {
            self::$instance->pdo =  null;
            self::$instance->statement = null;
            self::$instance = null;
        }
    }

}