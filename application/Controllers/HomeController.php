<?php 

namespace VTURefill\Controllers;
use VTURefill\Core\{Controller, View};



/**
 * Home
 */
class HomeController extends Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("frontend", "home/index", ["title" => "Home | VTURefill"]);
	}

}