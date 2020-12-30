<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Data;
use VTURefill\Core\{Controller, View, Json};


class DataController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'data/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allUsersOrders' => Data::getAllOrders(), 'allUsersOrdersCount' => '']);
	}

	public function mtnsme() {
		if ($this->request->method('get')) {
			$network = isset($this->request->get()['network']) ? $this->request->get()['network'] : ''; 
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : ''; 
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$plan = isset($this->request->get()['plan']) ? $this->request->get()['plan'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'plan' => $plan, 'amount' => $amount];
			$response = Data::mtnSmeData($data);
			Json::encode($response);
		}
	}

	public function direct() {
		if ($this->request->method('get')) {
			$network = isset($this->request->get()['network']) ? $this->request->get()['network'] : ''; 
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : ''; 
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$plan = isset($this->request->get()['plan']) ? $this->request->get()['plan'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'plan' => $plan, 'amount' => $amount];
			$response = Data::directDataTopUp($data);
			Json::encode($response);
		}
	}

}