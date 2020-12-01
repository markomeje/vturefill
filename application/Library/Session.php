<?php

namespace VTURefill\Library;
use VTURefill\Http\Cookie;


class Session {

    /**
     * Start a new PHP session if it's not already started.
     * @return [boolean] [true]
     * @static static method
     */
	public static function start() {
        //ini_set('session.use_strict_mode', 1);
		if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
	}

    /**
     * Checks if a session key exists in the session
     * @param  [string] $key [same as array key]
     * @return [boolean]      [true, false on failure]
     */
    public static function exists($key) {
        return (isset($_SESSION[$key])) ? true : false;
    }

    /**
     * Set a key
     * @param [string] $key   [same as array key]
     * @param [mixed] $value [any data type - boolean, string, integer ...]
     */
    public static function set($key, $value){
        session_regenerate_id();
        return $_SESSION[$key] = $value;
    }

    /**
     * Get a key from PHP session
     * @param  [string] $key [same as array key]
     * @return [boolean]      [session key, flas eon failure]
     */
    public static function get($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    /**
     * Unsets an existing session key
     * @param  [string] $key [same as array key]
     * @return [boolean]      [true or false]
     */
    public static function delete($key) {
        if(self::exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroys a session with any session cookie
     */
    public static function destroy(){
        if (ini_get("session.use_cookies")) {
            $values = session_get_cookie_params();
            Cookie::set(session_name(), "", time() - SESSION_COOKIE_EXPIRY, $values["path"], $values["domain"], $values["secure"], $values["httponly"]);
        }

        if(session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
            return true;
        }
    }


}
