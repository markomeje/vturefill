<?php

namespace Application\Http;


class Cookie {

	public static function set($name, $value, $expiry, $path = "", $domain = "", $secure = "", $http = "") {
		return setcookie($name, $value, $expiry, $path, $domain, $secure, $http);
	}

	public static function destroy($name) {
		return self::set($name, false, time() - (3600 * 3650), "/");
	}

	public static function get($name) {
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
	}

	public static function exists($name) {
		return isset($_COOKIE[$name]) ? true : false;
	}

}