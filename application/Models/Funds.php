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
			$database->prepare("INSERT INTO {$table} (user, amount, level) VALUES(:user, :amount, :level)");
			$database->execute($fields);
			return $database->rowCount() > 0;
	    } catch(Exception $error){
	        Logger::log("ADDING USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
        	return false;
	    }
	}

	public static function updateFund($data) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET amount = :amount WHERE user = :user LIMIT 1");
			$database->execute($data);
            return $database->rowCount() > 0;
		} catch (Exception $error) {
			Logger::log("UPDATING USER FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getFund($user) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE user = :user LIMIT 1");
			$database->execute(['user' => $user]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function creditFund($data) {
		try {
			$matched = Levels::getMatchedLevel($data['amount']);
			$level = empty($matched) ? 1 : $matched->level;
			$fund = self::getFund($data['user']);
			if(empty($fund)) {
				$merged = array_merge(['level' => $level], $data);
				if(!self::addFund($merged)) throw new Exception("Error Adding Fund For User ". $data['user']);
			}else {
				$previousBalance = empty($fund->amount) ? 0 : $fund->amount;
				$newBalance = $data['amount'] + $previousBalance;
				if(!self::updateFund(['user' => $data['user'], 'amount' => $newBalance])) throw new Exception("Error Crediting Fund For User ". $data['user']);
			}
		} catch (Exception $error) {
			Logger::log("CREDITING FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
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

	public static function debitFund($data) {
		try {
			$fund = self::getFund($data['user']);
			$previousBalance = empty($fund->amount) ? 0 : $fund->amount;
			$newBalance = $previousBalance - $data['amount'];
			if(!self::updateFund(['user' => $data['user'], 'amount' => $newBalance])) throw new Exception("Error Crediting Fund For User ". $data['user']);
			return true;
		} catch (Exception $error) {
			Logger::log("CREDITING FUND ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function isSufficientFunds($data) {
		try {
			$fund = self::getFund($data['user']);
			$previousBalance = empty($fund->amount) ? 0 : $fund->amount;
			return $previousBalance > $data['amount'];
		} catch (Exception $error) {
			Logger::log("CHECKING SUFFICIENT FUNDS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}