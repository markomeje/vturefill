<?php

namespace Application\Core;
use Application\Core\{View, Logger};
use Framework\Exceptions\RouterException;

class Router {


    public function __construct() {}
    
    
    public static function route($url) {
        $controller = (isset($url[0]) && $url[0] !== "") ? ucwords($url[0])."Controller" : "HomeController";
        $controller = "Framework\Controllers\\".$controller;
        array_shift($url);
        $method = (isset($url[0]) && $url[0] !== "") ? $url[0] : "index";
        array_shift($url);
        $arguments = empty($url) ? [] : array_values($url);
        try {
            if (class_exists($controller) === false) throw new RouterException();
            $controller = new $controller;
            if(method_exists($controller, $method) === false) throw new RouterException();
            empty($arguments) ? $controller->{$method}() : call_user_func_array([$controller, $method], $arguments);
        } catch (RouterException $error) {
            Logger::log("ROUTING ERROR", $error->getMessage(), __FILE__, __LINE__);
            exit(View::render("frontend", "codes/404", ["title" => "Page Not Found"]));
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

}
