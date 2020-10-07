<?php 

namespace Framework\Controllers;
use Framework\Models\Login;
use Application\Core\{Controller};



/**
 * Register
 */
class LoginController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if ($this->isPostRequest()) {
			$response = Login::login();
		    $this->jsonEncode($response);
		}
	}

}