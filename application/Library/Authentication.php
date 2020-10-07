<?php

namespace Application\Library;
use Application\Http\Cookie;
use Application\Library\Session;
use Application\Core\Router;

class Authentication {


	public static function authenticate($data) {
		Cookie::set(session_name(), session_id(), time() + SESSION_COOKIE_EXPIRY, COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECURE, COOKIE_HTTP);
		foreach ($data as $key => $value) {
			Session::set($key, $value);
		}
	}

	public static function allow($roles = []) {
		if (Session::get("isLoggedIn") !== true || !in_array(Session::get("role"), $roles)) {
			Session::destroy();
			Router::redirect("/login");
		}
	}

}