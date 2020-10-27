<?php 

namespace Framework\Controllers;
use Framework\Models\{Products, Categories};
use Application\Core\{Controller, View, Json};


class ProductsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "products/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "productStatus" => Products::$productStatus, "allProducts" => Products::getAllProducts(), "allCategories" => Categories::getAllCategories()]);
	}

	public function addProduct() {
		if ($this->request->isAjax()) {
			$response = Products::addProduct();
		    Json::encode($response);
		}
	}

	public function tarrifs($product) {
		View::render("backend", "tarrifs/index", []);
	}

}