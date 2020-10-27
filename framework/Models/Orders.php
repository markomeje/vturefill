<?php 

namespace Framework\Models;
use Application\Core\{Model};
use Application\Gateways\Clubkonnect;
use Application\Library\{Validate, Database};


class Orders extends Model {

    private static $table = "orders";
    public static $orderStatus = ["completed", "pending"];

	public function __construct() {
		parent::__construct();
	}

	public static function orderData($data) {
		if (empty($data["network"])) {
			return ["status" => 0, "message" => "Invalid mobile network"];
		}elseif(empty($data["phone"]) || !Validate::length($data["phone"], 11)) {
			return ["status" => 0, "message" => "Invalid phone number"];
		}elseif (empty($data["plan"])) {
			return ["status" => 0, "message" => "Invalid data plan"];
		}

		return Clubkonnect::buyDataBundle($data);

		// try {
		// 	$database = Database::connect();
		// 	$table = self::$table;
		// 	$database->prepare("INSERT INTO {$table} (order, status) VALUES(:order, :status)");
		// 	$database->execute($data);
		// 	$buyData = Clubkonnect::buyDataBundle($data);
		// 	return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		// } catch (Exception $error) {
		// 	Logger::log("ADDING ORDER ERROR", $error->getMessage(), __FILE__, __LINE__);
		// 	return ["status" => "error"];
		// }
	}

	public static function getAllOrdersCount() {}

	public static function getAllOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL ORDER ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getOrderById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute();
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING ORDER BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

