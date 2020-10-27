<?php 

namespace Framework\Controllers;
use Framework\Models\Networks;
use Application\Core\{Controller, View, Json};


class NetworksController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {}

	public function addNetwork() {
		if ($this->request->method("ajax")) {
			$response = Networks::addNetwork();
		    Json::encode($response);
		}
	}

	public function toggleNetworkStatus($id) {
		if ($this->request->method("ajax")) {
			$response = Networks::toggleNetworkStatus($id);
		    Json::encode($response);
		}
	}

}