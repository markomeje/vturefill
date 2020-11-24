<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Categories;
use VTURefill\Core\{Controller, View, Json};


class CategoriesController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'categories/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'categoryStatus' => Categories::$categoryStatus, 'allCategories' => Categories::getAllCategories()]);
	}

	public function addCategory() {
		if ($this->request->method('ajax')) {
			$data = ['status' => $this->request->post()['status'], 'category' => $this->request->post()['category']];
			$response = Categories::addCategory($data);
		    Json::encode($response);
		}
	}

}