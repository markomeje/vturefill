<?php 

namespace Framework\Controllers;
use Framework\Models\Orders;
use Application\Core\{Controller, View, Json};


class OrdersController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "orders/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allUsersOrders" => Orders::getAllOrders(), "allUsersOrdersCount" => Orders::getAllOrdersCount()]);
	}

	public function orderData() {
		if ($this->request->method("get")) {
			$data = ["network" => $this->request->get("network"), "phone" => $this->request->get("phone"), "plan" => $this->request->get("plan")];
			$response = Orders::orderData($data);
			Json::encode($response);
		}
	}

}