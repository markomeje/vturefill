<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Database};


class Networks extends Model {

    private static $table = 'networks';
    public static $networkStatus = ["manual", "normal"];

	public function __construct() {
		parent::__construct();
	}

	public static function addNetwork($data) {
		if (empty($data['name'])) {
			return ['status' => 'empty-name'];
		}elseif (empty($data['code'])) {
			return ['status' => 'empty-code'];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (name, status, code) VALUES(:name, :status, :code)");
			$merged = array_merge(['status' => 'manual'], $data);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING NETWORK ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}

	}

	public static function getAllNetworks() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL NETWORKS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function toggleNetworkStatus($id) {
		try {
			$network = self::getNetworkById($id);
			$newStatus = (isset($network->status) && strtolower($network->status) === "manual") ? "normal" : "manual";
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} set status = :status WHERE id = :id LIMIT 1");
			$database->execute(["id" => $id, "status" => $newStatus]);
            return $database->rowCount() > 0 ? ["status" => "success", "network" => ucfirst($newStatus)] : ["status" => "error", "network" => ucfirst($network->status)];
		} catch (Exception $error) {
			Logger::log("TOGGLING NETWORK STATUS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error", "network" => ucfirst($network->status)];
		}
	}

	public static function getNetworkById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(["id" => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING NETWORK BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function editNetwork($data, $id) {
		if (empty($data['name'])) {
			return ['status' => 'empty-name'];
		}elseif (empty($data['code'])) {
			return ['status' => 'empty-code'];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET name = :name, code = :code WHERE id = :id LIMIT 1");
			$merged = array_merge(['id' => $id], $data);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING NETWORK ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}

	}

	public static function getNetworkByCode($code) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE code = :code LIMIT 1");
			$database->execute(["code" => $code]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING NETWORK BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}