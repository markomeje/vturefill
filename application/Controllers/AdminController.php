<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Networks;
use VTURefill\Core\{Controller, View, Json};


class AdminController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {}

	public function setup() {
		if ($this->request->method('get')) {
			$data = ['allNetworks' => Networks::getAllNetworks(), 'contact' => ['email' => 'dikekingsely@vturefill.com', 'phone' => '0700000000']];
		    Json::encode($data);
		}
	}

}