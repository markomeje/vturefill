<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Register;
use VTURefill\Core\{Controller, Json};
use VTURefill\Http\Request;


class RegisterController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function signup() {
		if ($this->request->method('get')) {
			$username = isset($this->request->get()['username']) ? $this->request->get()['username'] : '';
			$email = isset($this->request->get()['email']) ? $this->request->get()['email'] : '';
			$password = isset($this->request->get()['password']) ? $this->request->get()['password'] : '';
			$confirmpassword = isset($this->request->get()['confirmpassword']) ? $this->request->get()['confirmpassword'] : '';
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : '';
			$data = ['username' => $username, 'email' => $email, 'password' => $password, 'confirmpassword' => $confirmpassword, 'phone' => $phone];
			$response = Register::signup($data);
		    Json::encode($response);
		}
	}

}