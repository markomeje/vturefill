<?php

namespace Framework\Models;
use Application\Core\{Model, Logger};
use Application\Library\{Validate, Database};
use \Exception;


class User extends Model {


	private static $table = "user";


	public function __construct() {
		parent::__construct();
	}

	public static function register($posted) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (username, email, password, phone, status) VALUES(:username, :email, :password, :phone, :status)");
			$database->execute($posted);
			return ["rowCount" => $database->rowCount(), "lastInsertId" => $database->lastInsertId()];
		} catch (Exception $error) {
			Logger::log("CREATING USER ACCOUNT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getUserById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT id, username, email, status, date, phone FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(["id" => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING USER BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function emailExists($email) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT email FROM {$table} WHERE email = :email LIMIT 1");
			$database->execute(["email" => $email]);
            return $database->rowCount() > 0 ? true : false;
		} catch (Exception $error) {
			Logger::log("CHECKING USER EMAIL EXISTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getUserByEmail($email) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE email = :email LIMIT 1");
			$database->execute(["email" => $email]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING USER BY EMAIL ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}