<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Levels;
use VTURefill\Core\{Controller, View, Json};


class LevelsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "levels/index", ['title' => '', "backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allLevels" => Levels::getAllLevels(), "levelStatus" => Levels::$levelStatus]);
	}

	public function addLevel() {
		if ($this->request->method('ajax')) {
			$level = isset($this->request->post()['level']) ? $this->request->post()['level'] : '';
			$description = isset($this->request->post()['description']) ? $this->request->post()['description'] : '';
			$minimum = isset($this->request->post()['minimum']) ? $this->request->post()['minimum'] : ''; 
			$maximum = isset($this->request->post()['maximum']) ? $this->request->post()['maximum'] : '';
			$discount = isset($this->request->post()['discount']) ? $this->request->post()['discount'] : '';
			$data = ['level' => $level, 'minimum' => $minimum, 'maximum' => $maximum, 'discount' => $discount, 'description' => $description];
			$response = Levels::addLevel($data);
		    Json::encode($response);
		}
	}

	public function editLevel($id) {
		if ($this->request->method('ajax')) {
			$level = isset($this->request->post()['level']) ? $this->request->post()['level'] : '';
			$description = isset($this->request->post()['description']) ? $this->request->post()['description'] : '';
			$minimum = isset($this->request->post()['minimum']) ? $this->request->post()['minimum'] : ''; 
			$maximum = isset($this->request->post()['maximum']) ? $this->request->post()['maximum'] : '';
			$discount = isset($this->request->post()['discount']) ? $this->request->post()['discount'] : '';
			$data = ['level' => $level, 'minimum' => $minimum, 'maximum' => $maximum, 'discount' => $discount, 'description' => $description];
			$response = Levels::editLevel($data, $id);
		    Json::encode($response);
		}
	}

	public function getAllLevels() {
		$response = Levels::getAllLevels();
		Json::encode($response);
	}

}