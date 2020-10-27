<?php 

namespace Framework\Controllers;
use Framework\Models\Payments;
use Application\Core\{Controller, View, Json};


class PaymentsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$allPayments = Payments::getAllPayments();
		View::render("backend", "payments/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allPayments" => $allPayments["allPayments"], "allPaymentsCount" => $allPayments["totalCount"]]);
	}

	public function pay() {
		if ($this->request->method("get")) {
			$response = Payments::addPayment();
			(isset($response["status"]) && $response["status"] === 1) ? header("Location: ". $response["redirect"]) : Json::encode($response);
		}
	}

	public function verify() {
		View::render("backend", "payments/verify", ["verifyUserPayment" => Payments::verifyPayment()]);
	}

	public function event() {}

}