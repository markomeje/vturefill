<?php 

namespace Framework\Controllers;
use Framework\Models\Levels;
use Application\Core\{Controller, View, Json};


class LevelsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "levels/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allLevels" => Levels::getAllLevels(), "levelStatus" => Levels::$levelStatus]);
	}

	public function addLevel() {
		if ($this->request->isAjax()) {
			$response = Levels::addLevel();
		    Json::encode($response);
		}
	}

}