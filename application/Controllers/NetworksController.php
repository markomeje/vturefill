<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Networks;
use VTURefill\Core\{Controller, View, Json};


class NetworksController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'networks/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allNetworks' => Networks::getAllNetworks()]);
	}

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