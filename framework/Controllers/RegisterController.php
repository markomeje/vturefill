<?php 

namespace Framework\Controllers;
use Framework\Models\Register;
use Application\Core\{Controller, View};



/**
 * Register
 */
class RegisterController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if ($this->isPostRequest()) {
			$response = Register::signup();
		    $this->jsonEncode($response);
		}
	}

}