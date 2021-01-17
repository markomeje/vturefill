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
		if ($this->request->method('get')) {
			$network = isset($this->request->get()['network']) ? $this->request->get()['network'] : ''; 
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : ''; 
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'amount' => $amount];
			$response = Airtime::airtimeTopUp($data);
			Json::encode($response);
		}
	}

}