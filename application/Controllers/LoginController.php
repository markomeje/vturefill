<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Login;
use VTURefill\Core\{Controller, View, Json};


class LoginController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
	    View::render('frontend', 'login/index', []);
	}

	public function login() {
		if ($this->request->method('post') || $this->request->method('ajax')) {
			$posted = ['email' => $this->request->post()['email'], 'password' => $this->request->post()['password']];
			$response = Login::login($posted);
		    Json::encode($response);
		}
	}

	public function logout() {}

}