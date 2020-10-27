<?php

namespace Application\Core;
use Application\Core\Help;


class Json {


    private function __construct(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }


    public static function encode($response){
        echo json_encode($response);
        exit();
    }

    public static function decode($response){
        echo json_decode($response);
        exit();
    }

}