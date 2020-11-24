<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Gateways};
use VTURefill\Library\{Validate, Database, Generate, Session};


class Funds extends Model {

    private static $table = "funds";


	public function __construct() {
		parent::__construct();
	}

	public static function addFund($fields) {
		try{
    		$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, amount, email) VALUES(:user, :amount, :email)");
			$database->execute($fields);
			return $database->rowCount() > 0 ? true : false;
	    } catch(Exception $error){
	        Logger::log("ADDING USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
        	return false;
	    }
	}

	public static function updateFund($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET amount = :amount WHERE user = :user AND email = :email LIMIT 1");
			$database->execute($fields);
            return $database->rowCount() > 0 ? true : false;
		} catch (Exception $error) {
			Logger::log("UPDATING USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getFund($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE user = :user AND email = :email LIMIT 1");
			$database->execute($fields);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function topUpFund($fields) {
		try {
			$condition = ["user" => $fields["user"]];
			$fund = self::getFund($condition);
			if(empty($fund) || $fund === false) {
				return self::addFund($fields) ? true : false;
			}else {
				$currentAmount = empty($fund->amount) ? 0 : $fund->amount;
				$merged = array_merge($condition, ["amount" => $currentAmount + $fields["amount"]]);
				return self::updateFund($merged) ? true : false;
			}
		} catch (Exception $error) {
			Logger::log("TOPING UP FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllFunds() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table}");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL FUNDS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}