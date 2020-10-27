<?php

namespace Application\Core;
use Application\Core\{Application, View};
use Application\Http\Request;


class Controller extends Application {

    public $activeController;
    public $backendLinks = ["categories", "orders", "dashboard", "products", "levels", "payments", "tariffs", "users"];
    protected $request;

    public function __construct() {
        parent::__construct();
        $this->request = new Request();
        $this->activeController = View::active(self::get("url"));
    }

}
