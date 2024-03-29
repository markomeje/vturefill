<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Payments;
use VTURefill\Core\{Controller, View, Json};


class PaymentsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$allPayments = Payments::getAllPayments();
		View::render('backend', 'payments/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allPayments' => $allPayments['allPayments'], 'allPaymentsCount' => $allPayments['count']]);
	}

	public function pay() {
		if ($this->request->method('get')) {
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$level = isset($this->request->get()['level']) ? $this->request->get()['level'] : '';  
			$data = ['user' => $user, 'amount' => $amount, 'level' => $level];
			$response = Payments::makePayment($data);
			(isset($response['status']) && $response['status'] === 1) ? header('Location: '. $response['redirect']) : Json::encode($response);
		}
	}

	public function verify() {
		$reference = isset($this->request->get()['reference']) ? $this->request->get()['reference'] : '';
		$response = Payments::verifyPayment($reference);
		Json::encode($response);
	}

}