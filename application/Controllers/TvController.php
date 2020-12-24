<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View, Json};


class TvController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if ($this->request->method('get')) {
			$response = ['tv' => ['Startimes', 'DSTV', 'GOTV']];
			Json::encode($response);
		}	
	}

}