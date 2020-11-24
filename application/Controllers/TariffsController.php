<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\{Networks, Tariffs};
use VTURefill\Core\{Controller, View, Json};



class TariffsController extends Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allNetworks' => Networks::getAllNetworks(), 'allTariffs' => Tariffs::getAllTariffs(), 'tariffStatus' => Tariffs::$tariffStatus];
		View::render('backend', 'tariffs/index', $data);
	}

	public function addTariff() {
		if ($this->request->method('ajax')) {
			$posted = ['network' => $this->request->post()['network'], 'amount' => $this->request->post()['amount'], 'duration' => $this->request->post()['duration'], 'bundle' => $this->request->post()['bundle'], 'code' => $this->request->post()['code'], 'status' => $this->request->post()['status']];
			$response = Tariffs::addTariff($posted);
		    Json::encode($response);
		}
	}

	public function editTariff($id) {
		if ($this->request->method('ajax')) {
			$posted = ['network' => $this->request->post()['network'], 'amount' => $this->request->post()['amount'], 'duration' => $this->request->post()['duration'], 'bundle' => $this->request->post()['bundle'], 'code' => $this->request->post()['code'], 'status' => $this->request->post()['status']];
			$response = Tariffs::editTariff($posted, $id);
		    Json::encode($response);
		}
	}

}