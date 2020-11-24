<?php

namespace VTURefill\Library;
use VTURefill\Http\Cookie;
use VTURefill\Library\Session;
use VTURefill\Core\Router;

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