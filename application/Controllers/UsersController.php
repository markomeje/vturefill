<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\Users;
use VTURefill\Core\{Controller, View, Json};


class UsersController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		View::render("backend", "levels/index", ["backendLinks" => $this->backendLinks, "activeController" => $this->activeController, "allLevels" => Users::getAllLevels()]);
	}

}