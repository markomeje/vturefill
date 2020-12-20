<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Orders;
use VTURefill\Core\{Controller, View, Json};


class OrdersController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'orders/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allUsersOrders' => Orders::getAllOrders(), 'allUsersOrdersCount' => '']);
	}

	public function airtime() {
		if ($this->request->method('post')) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : ''; 
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : ''; 
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'plan' => null, 'amount' => $amount];
			$response = Orders::airtimeTopUp($data);
			Json::encode($response);
		}
	}

	public function mtnsme() {
		if ($this->request->method('post')) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : ''; 
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : ''; 
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'plan' => $plan, 'amount' => $amount];
			$response = Orders::mtnSmeData($data);
			Json::encode($response);
		}
	}

	public function directData() {
		if ($this->request->method('post')) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : ''; 
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : ''; 
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$data = ['network' => $network, 'phone' => str_replace(' ', '', trim($phone)), 'user' => (int)$user, 'plan' => $plan, 'amount' => $amount];
			$response = Orders::directDataTopUp($data);
			Json::encode($response);
		}
	}

}