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
		if (empty($posted["email"]) || Users::emailExists($posted["email"]) === false) {
			return ["status" => "invalid-email", "message" => "Invalid user email"];
		}elseif (empty($posted["password"])) {
			return ["status" => "invalid-password", "message" => "Invalid password."];
		}

		try {
			$user = Users::getUserByEmail($posted["email"]);
			if(empty($user)) return ["status" => "invalid-user", "message" => "User not found."];
			$password = isset($user->password) ? $user->password : null;
			if(!password_verify($posted["password"], $password)) return ["status" => "invalid-login", "messsage" => "Your password is incorrect"];
			Authentication::authenticate(["id" => $user->id, "email" => $user->email, "username" => $user->username]);
			return ["status" => "success", "message" => "User successfully logged in", "user" => Users::getUserById($user->id)];
		} catch (Exception $error) {
			Logger::log("USER LOGIN ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error", "message" => "Login falied. Try again."];
		}
	}

}

