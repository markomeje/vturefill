<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Database};


class Levels extends Model {

    private static $table = "levels";
    public static $levelStatus = ["active", "inactive"];

	public function __construct() {
		parent::__construct();
	}

	public static function addLevel($posted) {	
		if (empty($posted["level"])) {
			return ["status" => "invalid-level"];
		}elseif(self::levelExists($posted["level"]) === true) {
			return ["status" => "level-exists"];
		}elseif (empty($posted['discount'])) {
			return ['status' => 'invalid-discount'];
		}elseif (empty($posted["minimum"])) {
			return ["status" => "invalid-minimum"];
		}elseif (empty($posted["maximum"])) {
			return ["status" => "invalid-maximum"];
		}elseif (empty($posted['description'])) {
			return ['status' => 'invalid-description'];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (minimum, discount, description, maximum, level) VALUES(:minimum, :discount, :description, :maximum, :level)");
			$database->execute($posted);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING LEVEL ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function getAllLevels() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL LEVELS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getMatchedLevel($amount) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT level FROM {$table} WHERE minimum <= :minimum AND maximum >= :maximum LIMIT 1");
			$database->execute(['minimum' => $amount, 'maximum' => $amount]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING MATCHED LEVEL ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getLevelById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute();
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING LEVEL BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function levelExists($level) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE level = :level LIMIT 1");
			$database->execute(["level" => $level]);
            return ($database->rowCount() > 0) ? true : false;
		} catch (Exception $error) {
			Logger::log("LEVEL EXISTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function editLevel($posted, $id) {	
		if (empty($posted["level"])) {
			return ["status" => "invalid-level"];
		}elseif (empty($posted['discount'])) {
			return ['status' => 'invalid-discount'];
		}elseif (empty($posted["minimum"])) {
			return ["status" => "invalid-minimum"];
		}elseif (empty($posted["maximum"])) {
			return ["status" => "invalid-maximum"];
		}elseif (empty($posted['description'])) {
			return ['status' => 'invalid-description'];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET minimum = :minimum, discount = :discount, description = :description, maximum = :maximum, level = :level WHERE id = :id LIMIT 1");
			$merged = array_merge(['id' => $id], $posted);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("EDITING LEVEL ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

}

