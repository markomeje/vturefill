<?php

namespace Application\Http;
use Application\Library\Validate;


class Request {


    public function __construct() {}


    public function method($method){
        $method = strtolower($method);
        if (strpos($method, "ajax") !== false || $method === "ajax") {
            return empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? null : strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === "xmlhttprequest";
        }elseif($method === "post" || $method === "get") {
            return empty($_SERVER['REQUEST_METHOD']) ? null : strtolower($_SERVER["REQUEST_METHOD"]) === $method;
        }
    }

    public function file($key){
        return isset($_FILES[$key]) ? $_FILES[$key] : "";
    }

    public function get($key){
        return isset($_GET[$key]) ? Validate::escape($_GET[$key]): "";
    }

    public function post($key){
        return isset($_POST[$key]) ? Validate::escape($_POST[$key]): "";
    }

}