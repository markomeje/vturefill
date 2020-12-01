<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Networks;
use VTURefill\Core\{Controller, View, Json};


class NetworksController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'networks/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allNetworks' => Networks::getAllNetworks(), 'networkStatus' => Networks::$networkStatus]);
	}

	public function addNetwork() {
		if ($this->request->method('ajax')) {
			$name = isset($this->request->post()['name']) ? $this->request->post()['name'] : ''; 
			$code = isset($this->request->post()['code']) ? $this->request->post()['code'] : ''; 
			$data = ['name' => $name, 'code' => $code];
			$response = Networks::addNetwork($data);
		    Json::encode($response);
		}
	}

	public function toggleNetworkStatus($id) {
		if ($this->request->method('ajax')) {
			$response = Networks::toggleNetworkStatus($id);
		    Json::encode($response);
		}
	}

	public function editNetwork($id) {
		if ($this->request->method('ajax')) {
			$name = isset($this->request->post()['name']) ? $this->request->post()['name'] : ''; 
			$code = isset($this->request->post()['code']) ? $this->request->post()['code'] : ''; 
			$data = ['name' => $name, 'code' => $code];
			$response = Networks::editNetwork($data, $id);
		    Json::encode($response);
		}
	}

}