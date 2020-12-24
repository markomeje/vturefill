<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Gateways\MobileairtimengGateway;


class ElectricityController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if ($this->request->method('get')) {
			$power = MobileairtimengGateway::powerLists();
			$response = ['electricity' => $power];
			Json::encode($response);
		}	
	}


}