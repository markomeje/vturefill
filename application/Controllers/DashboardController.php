<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\{Networks, Payments};
use VTURefill\Core\{Controller, View};


class DashboardController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$allNetworks = Networks::getAllNetworks();
		$allPayments = Payments::getAllPayments();
		$data = ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allNetworks" => $allNetworks, "allNetworksCount" => count($allNetworks), "networkStatus" => Networks::$networkStatus, "allPaymentsCount" => $allPayments['count'], 'allUsersCount' => 0, 'allOrdersCount' => 0, 'allCategoriesCount' => 0, 'allTariffsCount' => 0, 'allFundsCount' => 0, 'allLevelsCount' => 0];
		View::render("backend", "dashboard/index", $data);
	}

}