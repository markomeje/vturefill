<?php 

namespace Framework\Models;
use Application\Core\{Model};
use Application\Library\{Validate};


class Register extends Model {


	public function __construct() {
		parent::__construct();
	}

	public static function signup() {
		$posted = ["email" => self::post("email"), "password" => self::post("password"), "phone" => self::post("phone")];
		if (empty($posted["email"]) || !Validate::email($posted["email"]) || !Validate::range($posted["email"], 11, 55)) {
			return ["status" => "invalid-email", "message" => "Email must be between 11 - 55 characters"];
		}elseif (User::emailExists($posted["email"]) === true) {
			return ["status" => "email-exists", "message" => "Email already exists"];
		}elseif (empty($posted["password"])) {
			return ["status" => "invalid-password", "message" => "Invalid password."];
		}elseif (empty($posted["phone"]) || !Validate::length($posted["phone"], 11)) {
			return ["status" => "invalid-phone", "message" => "Invalid phone number."];
		}

		try {
			$posted["password"] = password_hash($posted["password"], PASSWORD_DEFAULT);
			$merged = array_merge($posted, ["status" => "inactive"]);
			$result = User::register($merged);
			$userId = empty($result["lastInsertId"]) ? 0 : $result["lastInsertId"];
			return (isset($result["rowCount"]) && $result["rowCount"] > 0) ? ["status" => "success", "message" => "Registration successfull", "user" => User::getUserById($userId)] : ["status" => "error", "message" => "Registration falied. Try again."];
		} catch (Exception $error) {
			Logger::log("USER REGISTRATION ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error", "message" => "Registration falied. Try again."];
		}
	}

}

