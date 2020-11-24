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
			$email = isset($this->request->post()['email']) ? $this->request->post()['email'] : '';
			$password = isset($this->request->post()['password']) ? $this->request->post()['password'] : '';
			$data = ['email' => $email, 'password' => $password];
			$response = Login::login($data);
		    Json::encode($response);
		}
	}

	public function logout() {}

}