<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Orders;
use VTURefill\Core\{Controller, View, Json};


class OrdersController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "orders/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allUsersOrders" => Orders::getAllOrders(), "allUsersOrdersCount" => Orders::getAllOrdersCount()]);
	}

	public function orderData() {
		if ($this->request->method("get")) {
			$network = isset($this->request->post()['network']) ? $this->request->post()['network'] : ''; 
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : ''; 
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : ''; 
			$id = isset($this->request->post()['id']) ? $this->request->post()['id'] : '';
			$data = ['network' => $network, 'phone' => $phone, 'plan' => $plan, 'id' => $id];
			$response = Orders::orderData($data);
			Json::encode($response);
		}
	}

}