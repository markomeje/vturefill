<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\{Products, Categories};
use VTURefill\Core\{Controller, View, Json};


class ProductsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render('backend', 'products/index', ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'productStatus' => Products::$productStatus, 'allProducts' => Products::getAllProducts(), 'allCategories' => Categories::getAllCategories()]);
	}

	public function addProduct() {
		if ($this->request->method('ajax')) {
			$posted = ['category' => $this->request->post()['category'], 'product' => $this->request->post()['product'], 'status' => 'active'];
			$response = Products::addProduct($posted);
		    Json::encode($response);
		}
	}

	public function tarrifs($product) {
		View::render('backend', 'tarrifs/index', []);
	}

}