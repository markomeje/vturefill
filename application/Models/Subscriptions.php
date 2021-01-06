<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger, Help};
use VTURefill\Library\{Validate, Database};
use \Exception;

/**
 * All TV Subscriptions
 */

class Subscriptions extends Model {

    private static $table = "subscriptions";
    public static $tvs = ['Startimes', 'GOtv', 'DStv'];

	public function __construct() {
		parent::__construct();
	}

	public static function addTvSubscription($posted) {
		if (empty($posted["plan"])) {
			return ["status" => "invalid-plan"];
		}elseif(empty($posted["amount"])) {
			return ["status" => "invalid-amount"];
		}elseif (empty($posted["tv"]) || !in_array($posted['tv'], self::$tvs, true)) {
			return ["status" => "invalid-tv"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$posted['duration'] = empty($posted['duration']) ? null : $posted['duration'];
			$database->prepare("INSERT INTO {$table} (amount, duration, plan, tv) VALUES( :amount, :duration, :plan, :tv)");
			$database->execute($posted);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING TV SUBSCRIPTION ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function getAllTvSubscriptions() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY amount DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL TV Subscription ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getSubscriptionByTv($tv) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE tv = :tv ORDER BY date DESC");
			$database->execute(['tv' => $tv]);
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING SUBSCRIPTION BY TV ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getSubscriptionById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(["id" => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING Subscription BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function editTvSubscription($posted, $id) {
		if (empty($posted["plan"])) {
			return ["status" => "invalid-plan"];
		}elseif(empty($posted["amount"])) {
			return ["status" => "invalid-amount"];
		}elseif (empty($posted["tv"]) || !in_array($posted['tv'], self::$tvs, true)) {
			return ["status" => "invalid-tv"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$posted['duration'] = empty($posted['duration']) ? null : $posted['duration'];
			$database->prepare("UPDATE {$table} SET amount = :amount, duration = :duration, tv = :tv, plan = :plan WHERE id = :id LIMIT 1");
			$merged = array_merge($posted, ['id' => $id]);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("EDITING TV Subscription ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

}