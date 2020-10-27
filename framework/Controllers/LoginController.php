<?php 

namespace Framework\Controllers;
use Framework\Models\Login;
use Application\Core\{Controller, View, Json};
use Application\Http\Request;


/**
 * Login
 */
class LoginController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
	    View::render("frontend", "login/index", []);
	}

	public function login() {
		if ($this->request->isPost() || $this->request->isAjax()) {
			$response = Login::login();
		    Json::encode($response);
		}
	}

	public function logout() {}

}