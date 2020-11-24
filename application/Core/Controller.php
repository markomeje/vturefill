<?php

namespace VTURefill\Core;
use VTURefill\Core\{Application, View};
use VTURefill\Http\Request;


class Controller {

    public $activeController;
    public $backendLinks = ["categories", "orders", "dashboard", "products", "levels", "payments", "tariffs", "users", 'funds'];
    public $request;

    public function __construct() {
        $this->request = new Request();
        $this->activeController = View::active($this->request->get()['route']);
    }

}
