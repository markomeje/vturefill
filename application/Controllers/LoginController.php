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

	/**
     * This is for the api Login
     */
	public function signin() {
		if ($this->request->method('post')) {
			$email = isset($this->request->post()['email']) ? $this->request->post()['email'] : '';
			$password = isset($this->request->post()['password']) ? $this->request->post()['password'] : '';
			$data = ['email' => $email, 'password' => $password];
			$response = Login::signin($data);
		    Json::encode($response);
		}
	}
    
    /**
     * Normal browser backend Login
     */
	public function login() {
		if ($this->request->method('ajax')) {
			$email = isset($this->request->post()['email']) ? $this->request->post()['email'] : '';
			$password = isset($this->request->post()['password']) ? $this->request->post()['password'] : '';
			$rememberme = isset($this->request->post()['rememberme']) ? $this->request->post()['rememberme'] : '';
			$data = ['email' => $email, 'password' => $password, 'rememberme' => $rememberme];
			$response = Login::login($data);
		    Json::encode($response);
		}
	}

}