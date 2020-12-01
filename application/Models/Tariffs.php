<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger};
use VTURefill\Library\{Validate, Database};
use \Exception;


class Tariffs extends Model {

    private static $table = "tariffs";
    public static $tariffStatus = ["active", "inactive"];

	public function __construct() {
		parent::__construct();
	}

	public static function addTariff($posted) {
		if(empty($posted["bundle"])) {
			return ["status" => "invalid-bundle"];
		}elseif (empty($posted["network"])) {
			return ["status" => "invalid-network"];
		}elseif(empty($posted["amount"])) {
			return ["status" => "invalid-amount"];
		}elseif(empty($posted["duration"])) {
			return ["status" => "invalid-duration"];
		}elseif (empty($posted["plan"])) {
			return ["status" => "invalid-plan"];
		}elseif (empty($posted["status"])) {
			return ["status" => "invalid-status"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (network, amount, duration, bundle, plan, status) VALUES(:network, :amount, :duration, :bundle, :plan, :status)");
			$database->execute($posted);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING TARIFF ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function getAllTariffs() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT {$table}.*, networks.name, networks.code FROM {$table}, networks WHERE networks.id = {$table}.network ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL TARIFFS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getTariffById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(["id" => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING TARIFF BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function editTariff($posted, $id) {
		if(empty($posted["bundle"])) {
			return ["status" => "invalid-bundle"];
		}elseif (empty($posted["network"])) {
			return ["status" => "invalid-network"];
		}elseif(empty($posted["amount"])) {
			return ["status" => "invalid-amount"];
		}elseif(empty($posted["duration"])) {
			return ["status" => "invalid-duration"];
		}elseif (empty($posted["plan"])) {
			return ["status" => "invalid-plan"];
		}elseif (empty($posted["status"])) {
			return ["status" => "invalid-status"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET network = :network, amount = :amount, duration = :duration, bundle = :bundle, status = :status, plan = :plan WHERE id = :id LIMIT 1");
			$merged = array_merge($posted, ["id" => $id]);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("EDITING TARIFF ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

}