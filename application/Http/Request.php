<?php declare(strict_types=1);

namespace VTURefill\Http;


final class Request {

	public function method($method){
        $method = strtolower($method);
        if (strpos($method, 'ajax') !== false || $method === 'ajax') {
            return empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? null : strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        }elseif($method === 'post' || $method === 'get') {
            return empty($_SERVER['REQUEST_METHOD']) ? null : strtolower($_SERVER['REQUEST_METHOD']) === $method;
        }
    }

    public function get(){
        $get = [];
        foreach ($_GET as $key => $value) {
            if(isset($key)) {
                $get[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $get;
    }

    public function post(){
        $post = [];
        foreach ($_POST as $key => $value) {
            if(isset($key)) {
                $post[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $post;
    }

}