<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Networks;
use VTURefill\Core\{Controller, View};


class DashboardController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$allNetworks = Networks::getAllNetworks();
		View::render("backend", "dashboard/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allNetworks" => $allNetworks, "allNetworksCount" => count($allNetworks), "networkStatus" => Networks::$networkStatus]);
	}

}