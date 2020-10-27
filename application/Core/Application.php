<?php

namespace Application\Core;

class Application {


    public function __construct() {
        self::unregisterGlobals();
    }

    private static function unregisterGlobals() {
        if(ini_get('register_globals')) {
            $globals = ['_SESSION', '_COOKIE', '_POST', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
            foreach($globals as $global) {
                foreach($GLOBALS[$global] as $key => $value) {
                    if($GLOBALS[$key] === $value) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    public static function IpAddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = null;
        }
        return $ip;
    }

    public static function file($key){
        $key = self::encode($key);
        return isset($_FILES[$key]) ? $_FILES[$key] : [];
    }

    public static function get($key){
        $key = self::encode($key);
        return isset($_GET[$key]) ? $_GET[$key]: [];
    }

    public static function post($key){
        $key = self::encode($key);
        return isset($_POST[$key]) ? $_POST[$key]: [];
    }

    public static function userAgent(){
        $agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $expression = '/\/[a-zA-Z0-9.]+/';
        return preg_replace($expression, '', $agent);
    }

    public static function encode($data){
        return htmlentities($data, ENT_QUOTES, 'UTF-8');
    }

}
