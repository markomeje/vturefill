<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Models\{Transactions};


class TransactionsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {}

	public function history() {
		if ($this->request->method('post')) {
			$user = isset($this->request->post()['user']) ? $this->request->post()['user'] : '';
			$response = Transactions::getAllUserTransactionHistory($user);
			Json::encode($response);
		}
	}


}