<?php 

namespace Framework\Controllers;
use Framework\Models\{Urls};
use Application\Core\{Controller, View, Json};



/**
 * Home
 */
class UrlsController extends Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "urls/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "urlStatus" => Urls::$urlStatus]);
	}

	public function addUrl() {
		if ($this->request->ajax()) {
			$response = Urls::addUrl();
		    Json::encode($response);
		}
	}

}