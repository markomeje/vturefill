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

	public function orderData() {
		if ($this->request->method('get')) {
			$network = isset($this->request->get()['network']) ? $this->request->get()['network'] : ''; 
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : ''; 
			$plan = isset($this->request->get()['plan']) ? $this->request->get()['plan'] : ''; 
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$data = ['network' => $network, 'phone' => $phone, 'plan' => $plan, 'user' => (int)$user, 'amount' => $amount];
			$response = Orders::orderData($data);
			Json::encode($response);
		}
	}

}