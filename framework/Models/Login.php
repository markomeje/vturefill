<?php 

namespace Framework\Models;
use Application\Core\{Model};
use Application\Library\{Validate};


class Login extends Model {


	public function __construct() {
		parent::__construct();
	}

	public static function login() {
		$posted = ["email" => self::post("email"), "password" => self::post("password")];
		if (empty($posted["email"]) || User::emailExists($posted["email"]) === false) {
			return ["status" => "empty-email", "message" => "Invalid user email"];
		}elseif (empty($posted["password"])) {
			return ["status" => "empty-password", "message" => "Invalid password."];
		}

		try {
			$user = User::getUserByEmail($posted["email"]);
			if(empty($user)) return ["status" => "invalid-user", "message" => "User not found."];
			$password = isset($user->password) ? $user->password : null;
			if(!password_verify($posted["password"], $password)) return ["status" => "incorrect-password", "messsage" => "Your password is incorrect"];
			return ["status" => "login-success", "message" => "User successfully logged in", "user" => User::getUserById($user->id)];
		} catch (Exception $error) {
			Logger::log("USER LOGIN ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error", "message" => "Login falied. Try again."];
		}
	}

}

