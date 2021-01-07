<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Models\{Tv, Subscriptions};


class TvController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function startimes() {
		if ($this->request->method('get')) {
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$smartno = isset($this->request->get()['smartno']) ? $this->request->get()['smartno'] : '';
			$customer = isset($this->request->get()['customer']) ? $this->request->get()['customer'] : '';
			$invoice = isset($this->request->get()['invoice']) ? $this->request->get()['invoice'] : '';
			$customernumber = isset($this->request->get()['customernumber']) ? $this->request->get()['customernumber'] : '';
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$data = ['phone' => $phone, 'amount' => $amount, 'smartno' => $smartno, 'customer' => $customer, 'invoice' => $invoice, 'billtype' => 'startimes', 'customernumber' => $customernumber, 'user' => $user];
			$response = Tv::subscribeStartimes($data);
			Json::encode($response);
		}
	}

	public function index() {
		if ($this->request->method('get')) {
			$response = ['tv' => Subscriptions::$tvs];
			Json::encode($response);
		}	
	}

	public function validate() {
		if ($this->request->method('get')) {
			$bill = isset($this->request->get()['bill']) ? $this->request->get()['bill'] : '';
			$smartno = isset($this->request->get()['smartno']) ? $this->request->get()['smartno'] : '';
			$data = ['bill' => $bill, 'smartno' => $smartno];
			$response = Tv::validateTvMeterNumber($data);
			Json::encode($response);
		}
	}

	public function gotvdstv() {
		if ($this->request->method('get')) {
			$phone = isset($this->request->get()['phone']) ? $this->request->get()['phone'] : '';
			$amount = isset($this->request->get()['amount']) ? $this->request->get()['amount'] : '';
			$smartno = isset($this->request->get()['smartno']) ? $this->request->get()['smartno'] : '';
			$customer = isset($this->request->get()['customer']) ? $this->request->get()['customer'] : '';
			$invoice = isset($this->request->get()['invoice']) ? $this->request->get()['invoice'] : '';
			$billtype = isset($this->request->get()['billtype']) ? $this->request->get()['billtype'] : '';
			$customernumber = isset($this->request->get()['customernumber']) ? $this->request->get()['customernumber'] : '';
			$user = isset($this->request->get()['user']) ? $this->request->get()['user'] : '';
			$data = ['phone' => $phone, 'amount' => $amount, 'smartno' => $smartno, 'customer' => $customer, 'invoice' => $invoice, 'billtype' => $billtype, 'customernumber' => $customernumber, 'user' => $user];
			$response = Tv::subscribeGotvDstv($data);
			Json::encode($response);
		}
	}

}