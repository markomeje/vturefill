<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};
use VTURefill\Models\{Tv, Subscriptions};


class TvController extends Controller {

	
	public function __construct() {
		parent::__construct();
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
			$response = Tv::validateMeterNumber($data);
			Json::encode($response);
		}
	}

}