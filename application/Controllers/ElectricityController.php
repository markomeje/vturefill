<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Gateways\MobileairtimengGateway;
use VTURefill\Models\Electricity;


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

	public function validate() {
		if ($this->request->method('get')) {
			$service = isset($this->request->get()['service']) ? $this->request->get()['service'] : '';
			$meterno = isset($this->request->get()['meterno']) ? $this->request->get()['meterno'] : '';
			$data = ['service' => $service, 'meterno' => $meterno];
			$response = Electricity::validateMeterNumber($data);
			Json::encode($response);
		}
	}

	public static function buy() {
		if ($this->request->method('post')) {
			$service = isset($this->request->post()['service']) ? $this->request->post()['service'] : '';
			$meterno = isset($this->request->post()['meterno']) ? $this->request->post()['meterno'] : '';
			$mtype = isset($this->request->post()['mtype']) ? $this->request->post()['mtype'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$data = ['service' => $service, 'meterno' => $meterno, 'mtype' => $mtype, 'amount' => $amount, 'user' => $user];
			$response = Electricity::buyElectricity($data);
			Json::encode($response);
		}
	}


}