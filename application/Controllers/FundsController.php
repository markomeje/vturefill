<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Funds;
use VTURefill\Core\{Controller, View, Json};


class FundsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "funds/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allFunds" => Funds::getAllFunds()]);
	}

	public function addFund() {
		if ($this->request->method("get")) {
			$response = Funds::addFund();
			(isset($response["status"]) && $response["status"] === 1) ? header("Location: ". $response["redirect"]) : Json::encode($response);
		}
	}

	public function verify() {
		View::render("backend", "funds/verify", [$verifyFund => Funds::verifyFund()]);
	}

}