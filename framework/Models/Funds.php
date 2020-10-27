<?php 

namespace Framework\Models;
use Application\Core\{Model, Gateways};
use Application\Library\{Validate, Database, Generate, Session};


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
			return $database->rowCount();
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
            return $database->rowCount();
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
			Logger::log("GETTING USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function topUpFund($fields) {
		try {
			$where = ["user" => $fields["user"], "email" => $fields["email"]];
			$userFund = self::getUserFund($where);
			if(empty($userFund) || $userFund === false) {
				return self::addUserFund($fields) > 0 ? true : false;
			}else {
				$currentAmount = empty($userFund->amount) ? 0 : $userFund->amount;
				$merged = array_merge($where, ["amount" => $currentAmount + $fields["amount"]]);
				return self::updateUserFund($merged) > 0 ? true : false;
			}
		} catch (Exception $error) {
			Logger::log("TOPING UP USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
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
			Logger::log("GETTING USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}