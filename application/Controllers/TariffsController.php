<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\{Networks, Tariffs};
use VTURefill\Core\{Controller, View, Json};



class TariffsController extends Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allNetworks' => Networks::getAllNetworks(), 'allTariffs' => Tariffs::getAllTariffs(), 'tariffType' => Tariffs::$tariffType];
		View::render('backend', 'tariffs/index', $data);
	}

	public function addTariff() {
		if ($this->request->method('ajax')) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$duration = isset($this->request->post()['duration']) ? $this->request->post()['duration'] : '';
			$bundle = isset($this->request->post()['bundle']) ? $this->request->post()['bundle'] : '';
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : '';
			$type = isset($this->request->post()['type']) ? $this->request->post()['type'] : '';
			$posted = ['network' => $network, 'amount' => $amount, 'duration' => $amount, 'bundle' => $bundle, 'plan' => $plan, 'type' => $type];
			$response = Tariffs::addTariff($posted);
		    Json::encode($response);
		}
	}

	public function editTariff($id) {
		if ($this->request->method('ajax')) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$duration = isset($this->request->post()['duration']) ? $this->request->post()['duration'] : '';
			$bundle = isset($this->request->post()['bundle']) ? $this->request->post()['bundle'] : '';
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : '';
			$type = isset($this->request->post()['type']) ? $this->request->post()['type'] : '';
			$posted = ['network' => $network, 'amount' => $amount, 'duration' => $duration, 'bundle' => $bundle, 'plan' => $plan, 'type' => $type];
			$response = Tariffs::editTariff($posted, $id);
		    Json::encode($response);
		}
	}

	public function getAllTariffs() {
		if ($this->request->method('post')) {
			$response = Tariffs::getAllTariffs();
			Json::encode($response);
		}
	}

	public function getTariffsByUserLevel($user = '') {
		$response = Tariffs::getTariffsByUserLevel($user);
		Json::encode($response);
	}

}