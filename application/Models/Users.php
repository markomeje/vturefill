<?php

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger};
use VTURefill\Library\{Validate, Database};
use \Exception;


class Users extends Model {


	private static $table = "users";


	public function __construct() {
		parent::__construct();
	}

	public static function register($posted) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (username, email, password, phone, status) VALUES(:username, :email, :password, :phone, :status)");
			$database->execute($posted);
			return ["count" => $database->rowCount(), "id" => $database->lastInsertId()];
		} catch (Exception $error) {
			Logger::log("CREATING USER ACCOUNT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getById($id) {
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

	public static function getByEmail($email) {
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

	public static function phoneExists($phone) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT phone FROM {$table} WHERE email = :phone LIMIT 1");
			$database->execute(["phone" => $phone]);
            return $database->rowCount() > 0 ? true : false;
		} catch (Exception $error) {
			Logger::log("CHECKING USER PHONE NUMBER EXISTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getByPhone($phone) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE phone = :phone LIMIT 1");
			$database->execute(['phone' => $phone]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log('GETTING USER BY EMAIL ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllUsers() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING USER BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}


}