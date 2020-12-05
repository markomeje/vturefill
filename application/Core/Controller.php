<?php

namespace VTURefill\Core;
use VTURefill\Core\{Application, View};
use VTURefill\Http\Request;


class Controller {

    public $activeController;
    public $backendLinks = ['categories', 'orders', 'networks', 'dashboard', 'products', 'levels', 'payments', 'tariffs', 'users', 'funds'];
    public $request;

    public function __construct() {
        $this->request = new Request();
        $route = isset($this->request->get()['route']) ? $this->request->get()['route'] : '';
        $this->activeController = View::active($route);
    }

}
