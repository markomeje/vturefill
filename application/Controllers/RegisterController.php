<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Register;
use VTURefill\Core\{Controller, Json};
use VTURefill\Http\Request;


class RegisterController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {}

	public function signup() {
		if ($this->request->method('post')) {
			$username = isset($this->request->post()['username']) ? $this->request->post()['username'] : '';
			$email = isset($this->request->post()['email']) ? $this->request->post()['email'] : '';
			$password = isset($this->request->post()['password']) ? $this->request->post()['password'] : '';
			$confirmpassword = isset($this->request->post()['confirmpassword']) ? $this->request->post()['confirmpassword'] : '';
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : '';
			$data = ['username' => $username, 'email' => $email, 'password' => $password, 'confirmpassword' => $confirmpassword, 'phone' => $phone];
			$response = Register::signup($data);
		    Json::encode($response);
		}
	}

}