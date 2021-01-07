<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Models\{Tv, Subscriptions};


class TvController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function startimes() {
		if ($this->request->method('post')) {
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$smartno = isset($this->request->post()['smartno']) ? $this->request->post()['smartno'] : '';
			$customer = isset($this->request->post()['customer']) ? $this->request->post()['customer'] : '';
			$invoice = isset($this->request->post()['invoice']) ? $this->request->post()['invoice'] : '';
			$customernumber = isset($this->request->post()['customernumber']) ? $this->request->post()['customernumber'] : '';
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$data = ['phone' => $phone, 'amount' => $amount, 'smartno' => $smartno, 'customer' => $customer, 'invoice' => $invoice, 'billtype' => 'startimes', 'customernumber' => $customernumber, 'user' => $user];
			$response = Tv::subscribeStartimes($data);
			Json::encode($response);
		}
	}

	public function index() {
		if ($this->request->method('post')) {
			$response = ['tv' => Subscriptions::$tvs];
			Json::encode($response);
		}	
	}

	public function validate() {
		if ($this->request->method('post')) {
			$bill = isset($this->request->post()['bill']) ? $this->request->post()['bill'] : '';
			$smartno = isset($this->request->post()['smartno']) ? $this->request->post()['smartno'] : '';
			$data = ['bill' => $bill, 'smartno' => $smartno];
			$response = Tv::validateTvMeterNumber($data);
			Json::encode($response);
		}
	}

	public function gotvdstv() {
		if ($this->request->method('post')) {
			$phone = isset($this->request->post()['phone']) ? $this->request->post()['phone'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$smartno = isset($this->request->post()['smartno']) ? $this->request->post()['smartno'] : '';
			$customer = isset($this->request->post()['customer']) ? $this->request->post()['customer'] : '';
			$invoice = isset($this->request->post()['invoice']) ? $this->request->post()['invoice'] : '';
			$billtype = isset($this->request->post()['billtype']) ? $this->request->post()['billtype'] : '';
			$customernumber = isset($this->request->post()['customernumber']) ? $this->request->post()['customernumber'] : '';
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$data = ['phone' => $phone, 'amount' => $amount, 'smartno' => $smartno, 'customer' => $customer, 'invoice' => $invoice, 'billtype' => $billtype, 'customernumber' => $customernumber, 'user' => $user];
			$response = Tv::subscribeGotvDstv($data);
			Json::encode($response);
		}
	}

}