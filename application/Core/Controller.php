<?php

namespace Application\Core;
use Application\Core\{Application, View};
use Gregwar\Captcha\CaptchaBuilder;
use Application\Library\{Session, Cookie};


class Controller extends Application {

    public $controller;

    public function __construct() {
        parent::__construct();
        $controller = self::get("url");
        $this->controller = View::active($controller);
    }

    public function isAjaxRequest(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
            return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        }
    }

    public function getCaptcha(){
        $captcha = new CaptchaBuilder;
        $captcha->build();
        Session::set('captcha', $captcha->getPhrase());
        return $captcha;
    }

    public function isPostRequest() {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    public function setHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function jsonEncode($response){
      	$this->setHeaders();
      	echo json_encode($response);
    }

    public function jsonDecode($response){
      	$this->setHeaders();
      	echo json_decode($response);
    }

    public function isGetRequest() {
        return $_SERVER["REQUEST_METHOD"] === "GET";
    }

}
