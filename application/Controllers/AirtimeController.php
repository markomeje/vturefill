<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Airtime;
use VTURefill\Core\{Controller, View, Json};


class AirtimeController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'airtime/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allUsersOrders' => Airtime::getAllAirtimeOrders(), 'allUsersOrdersCount' => '']);
	}

	public function buy() {
		if ($this->request->method('post')) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : ''; 
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : ''; 
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'amount' => $amount];
			$response = Airtime::airtimeTopUp($data);
			Json::encode($response);
		}
	}

}