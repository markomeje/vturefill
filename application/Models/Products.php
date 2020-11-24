<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Database};
use \Exception;


class Products extends Model {

    private static $table = "products";
    public static $productStatus = ["active", "inactive"];

	public function __construct() {
		parent::__construct();
	}

	public static function addProduct($posted) {
		if (empty($posted["product"])) {
			return ["status" => "invalid-product"];
		}elseif(self::productExistsForCategory($posted["product"], $posted["category"]) === true) {
			return ["status" => "product-exists"];
		}elseif (empty($posted["category"])) {
			return ["status" => "invalid-category"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (product, category, status) VALUES(:product, :category, :status)");
			$database->execute($posted);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING PRODUCT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function productExistsForCategory($product, $category) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT product, category FROM {$table} WHERE product = :product AND category = :category LIMIT 1");
			$database->execute(["product" => $product, "category" => $category]);
            return ($database->rowCount() > 0) ? true : false;
		} catch (Exception $error) {
			Logger::log("PRODUCT EXISTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllProducts() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT {$table}.id, {$table}.product as name, {$table}.category, {$table}.date, categories.category as family FROM {$table}, categories WHERE {$table}.category = categories.id ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL PRODUCTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getDataBundleProducts() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT id, product FROM {$table} GROUP BY product ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL PRODUCTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

