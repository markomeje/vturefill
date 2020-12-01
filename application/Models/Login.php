<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Authentication, Generate};
use VTURefill\Http\Cookie;
use VTURefill\Models\{Funds};

class Login extends Model {


	public function __construct() {
		parent::__construct();
	}
    
    /**
     * Login for api
     */
	public static function signin($posted) {
		if (empty($posted['email'])) {
			return ['status' => 0, 'message' => 'Email is required'];
		}elseif (empty($posted['password'])) {
			return ['status' => 0, 'message' => 'Password is required'];
		}

		try {
			$user = User::getByEmail($posted['email']);
			if(empty($user)) return ['status' => 0, 'message' => 'User not found.'];
			$password = isset($user->password) ? $user->password : null;
			$id = isset($user->id) ? $user->id : 0;
			if(!password_verify($posted['password'], $password)) return ['status' => 0, 'messsage' => 'Your password is incorrect'];
			$funds = Funds::getFund($id);
			return ['status' => 1, 'message' => 'Login successfull', 'user' => User::getById($id), 'token' => Generate::hash(15), 'funds' => empty($funds) ? 0 : $funds];
		} catch (Exception $error) {
			Logger::log('USER LOGIN ERROR', $error->getMessage(), __FILE__, __LINE__);
			return ['status' => 0, 'message' => 'Login falied. Try again.'];
		}
	}
    
    /**
     * Normal browser login for Backend
     */
	public static function login($posted) {
		if (empty($posted['email'])) {
			return ['status' => 'empty-email'];
		}elseif (empty($posted['password'])) {
			return ['status' => 'empty-password'];
		}

		try {
			$user = User::getByEmail($posted['email']);
			if(empty($user)) return ['status' => 'invalid-login'];
			$password = isset($user->password) ? $user->password : null;
			$id = isset($user->id) ? $user->id : 0;
			if(!password_verify($posted['password'], $password)) return ['status' => 'invalid-login'];
			if(isset($posted['rememberme']) && strtolower($posted['rememberme']) === 'on') Cookie::set(REMEMBER_ME_COOKIE_NAME, 'active', time() + REMEMBER_ME_COOKIE_EXPIRY, COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECURE, COOKIE_HTTP);
			Authentication::authenticate(['id' => $id]);
			return ['status' => 'success'];
		} catch (Exception $error) {
			Logger::log('USER LOGIN ERROR', $error->getMessage(), __FILE__, __LINE__);
			return ['status' => 'error'];
		}
	}

}

