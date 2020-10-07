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
			$database->prepare("INSERT INTO {$table} (email, password, phone, status) VALUES(:email, :password, :phone, :status)");
			$database->execute($posted);
            return $database->rowCount() > 0 ? true : false;
		} catch (Exception $error) {
			Logger::log("CREATING USER ACCOUNT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}

	}

}