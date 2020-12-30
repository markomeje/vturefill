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
			$data = ['allNetworks' => Networks::getAllNetworks(), 'contact' => ['email' => 'contact@vturefill.com', 'phone' => '08147067514'], 'data' => ['sme' => Tariffs::getTariffsByType('sme'), 'direct' => Tariffs::getTariffsByType('direct')], 'electricity' => MobileairtimengGateway::powerLists(), 'tv' => ['GOTV', 'DSTV', 'STARTIMES']];
		    Json::encode($data);
		}
	}

}