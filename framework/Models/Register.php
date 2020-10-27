<?php 

namespace Framework\Models;
use Application\Core\{Model};
use Application\Library\{Validate};


class Register extends Model {


	public function __construct() {
		parent::__construct();
	}

	public static function signup() {
		$posted = ["username" => self::post("username"), "email" => self::post("email"), "password" => self::post("password"), "confirmpassword" => self::post("confirmpassword"), "phone" => self::post("phone")];
		if (empty($posted["username"]) || !Validate::range($posted["username"], 8, 15)) {
			return ["status" => 0, "message" => "Username must be between 8 - 15 characters"];
		}elseif (empty($posted["email"]) || !Validate::email($posted["email"]) || !Validate::range($posted["email"], 11, 55)) {
			return ["status" => 0, "message" => "Email must be between 11 - 55 characters"];
		}elseif (Users::emailExists($posted["email"]) === true) {
			return ["status" => 0, "message" => "Email already exists"];
		}elseif (empty($posted["password"])) {
			return ["status" => "invalid-password", "message" => "Invalid password."];
		}elseif ($posted["password"] !== $posted["confirmpassword"]) {
			return ["status" => 0, "message" => "Passwords do not match."];
		}elseif (empty($posted["phone"]) || !Validate::length($posted["phone"], 11)) {
			return ["status" => 0, "message" => "Invalid phone number."];
		}

		try {
			unset($posted["confirmpassword"]);
			$posted["password"] = password_hash($posted["password"], PASSWORD_DEFAULT);
			$merged = array_merge($posted, ["status" => "inactive"]);
			$result = Users::register($merged);
			$id = empty($result["id"]) ? 0 : $result["id"];
			return (isset($result["rowCount"]) && $result["rowCount"] > 0) ? ["status" => 1, "message" => "Registration successfull", "user" => Users::getUserById($id)] : ["status" => 0, "message" => "Registration falied. Try again."];
		} catch (Exception $error) {
			Logger::log("USER REGISTRATION ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => 0, "message" => "Registration falied. Try again."];
		}
	}

}
