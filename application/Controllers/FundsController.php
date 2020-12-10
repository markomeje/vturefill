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

}