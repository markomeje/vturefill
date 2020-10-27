<?php 

namespace Framework\Controllers;
use Framework\Models\Register;
use Application\Core\{Controller, Request, Json};



/**
 * Register
 */
class RegisterController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if ($this->request->isPost()) {
			$response = Register::signup();
		    json::encode($response);
		}
	}

}