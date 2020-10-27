<?php 

namespace Framework\Controllers;
use Framework\Models\Funds;
use Application\Core\{Controller, View, Json};


class FundsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "funds/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "fundStatus" => Funds::$fundStatus, "allFunds" => Funds::getAllFunds()]);
	}

	public function addFund() {
		if ($this->request->isGet()) {
			$response = Funds::addFund();
			(isset($response["status"]) && $response["status"] === 1) ? header("Location: ". $response["redirect"]) : Json::encode($response);
		}
	}

	public function verify() {
		$data = [$verifyFund => Funds::verifyFund()];
		View::render("backend", "funds/verify", $data);
	}

}