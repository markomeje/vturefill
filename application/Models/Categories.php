<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Database};


class Categories extends Model {

    private static $table = "categories";
    public static $categoryStatus = ["active", "inactive"];

	public function __construct() {
		parent::__construct();
	}

	public static function addCategory($data) {
		if (empty($data["category"])) {
			return ["status" => "invalid-category"];
		}elseif(self::categoryExists($data["category"]) === true) {
			return ["status" => "category-exists"];
		}elseif (empty($data["status"])) {
			return ["status" => "invalid-status"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (category, status) VALUES(:category, :status)");
			$database->execute($data);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING CATEGORY ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function categoryExists($category) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT category FROM {$table} WHERE category = :category LIMIT 1");
			$database->execute(["category" => $category]);
            return $database->rowCount() > 0 ? true : false;
		} catch (Exception $error) {
			Logger::log("CATEGORY EXISTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllCategories() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL CATEGORIES ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getCategoryById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute();
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING CATEGORY BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

