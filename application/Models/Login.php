<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate};


class Login extends Model {


	public function __construct() {
		parent::__construct();
	}

	public static function login($posted) {
		if (empty($posted["email"])) {
			return ["status" => 0, "message" => "Invalid email"];
		}elseif (empty($posted["password"])) {
			return ["status" => 0, "message" => "Invalid password."];
		}

		try {
			$user = User::getByEmail($posted["email"]);
			if(empty($user)) return ["status" => 0, "message" => "User not found."];
			$password = isset($user->password) ? $user->password : null;
			if(!password_verify($posted["password"], $password)) return ["status" => 0, "messsage" => "Your password is incorrect"];
			Authentication::authenticate(["id" => $user->id]);
			return ["status" => 1, "message" => "User successfully logged in", "user" => User::getById($user->id)];
		} catch (Exception $error) {
			Logger::log("USER LOGIN ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error", "message" => "Login falied. Try again."];
		}
	}

}

