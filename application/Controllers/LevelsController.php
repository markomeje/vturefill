<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Levels;
use VTURefill\Core\{Controller, View, Json};


class LevelsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "levels/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allLevels" => Levels::getAllLevels(), "levelStatus" => Levels::$levelStatus]);
	}

	public function addLevel() {
		if ($this->request->method('ajax')) {
			$level = isset($this->request->post()['level']) ? $this->request->post()['level'] : ''; 
			$status = isset($this->request->post()['status']) ? $this->request->post()['status'] : ''; 
			$minimum = isset($this->request->post()['minimum']) ? $this->request->post()['minimum'] : ''; 
			$maximum = isset($this->request->post()['maximum']) ? $this->request->post()['maximum'] : '';
			$data = ['level' => $level, 'status' => $status, 'minimum' => $minimum, 'maximum' => $maximum];
			$response = Levels::addLevel($data);
		    Json::encode($response);
		}
	}

}