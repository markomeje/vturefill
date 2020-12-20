<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\{Networks, Tariffs};
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Gateways\MobileairtimengGateway;


class AdminController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {}

	public function setup() {
		if ($this->request->method('get')) {
			$power = MobileairtimengGateway::powerLists();
			$data = ['allNetworks' => Networks::getAllNetworks(), 'contact' => ['email' => 'dikekingsely@vturefill.com', 'phone' => '0700000000'], 'data' => ['sme' => Tariffs::getTariffsByType('sme'), 'direct' => Tariffs::getTariffsByType('direct')], 'electricity' => $power, 'tv' => ['GOTV', 'DSTV', 'STARTIMES']];
		    Json::encode($data);
		}
	}

}