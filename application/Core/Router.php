<?php

namespace Application\Core;
use Application\Core\View;


class Router {


    public function __construct() {}
    /**
     method that routes the url
     * @param  [array] $url [contains an array of current url in the browser]
     * @return [object]      [an instance ocontroller being called]
     */
    
    public static function route($url) {
        $controller = (isset($url[0]) && $url[0] !== "") ? ucwords($url[0])."Controller" : "HomeController";
        $controller = "Framework\Controllers\\".$controller;
        array_shift($url);
        $method = (isset($url[0]) && $url[0] !== "") ? $url[0] : "index";
        array_shift($url);
        $arguments = empty($url) ? [] : array_values($url);
        if (self::isValidController($controller) === true) {
            $controller = new $controller;
            if(self::isValidMethod($controller, $method) === true) {
                empty($arguments) ? $controller->{$method}() : call_user_func_array([$controller, $method], $arguments);
            } else {
                self::httpStatus("404", "Page Not Found");
            }
        }else {
            self::httpStatus("404", "Page Not Found");
        } 
    }

    private static function isValidController($controller){
        if(!empty($controller)){
            return (preg_match('/\A[a-z]+\z/i', $controller) || class_exists($controller) || ucwords($controller) === "HomeController") ? true : false;
        }else { 
            return false; 
        }
    }

    private static function isValidMethod($controller, $method){
        if(!empty($method)){
            return (preg_match('/\A[a-z]+\z/i', $method) || method_exists($controller, $method)  || strtolower($method) === "index") ? true : false;
        }else { 
            return false; 
        }
    }

    public static function redirect($location) {
        if (!headers_sent()) {
            header('Location: '.DOMAIN.$location);
        }else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.DOMAIN.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
            echo '</noscript>';
            exit;
        }
    }

    public static function httpStatus($code, $title = "") {
        View::render("frontend", "codes/{$code}", ["title" => $title]);
        return http_response_code($code);
    }

}
