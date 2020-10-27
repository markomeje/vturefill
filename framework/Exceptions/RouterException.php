<?php

namespace Application\Exceptions;


class RouterException extends \Exception {

	public $message = 'The Requested Route was not found on the server.';

	public $code = 404;

	public function __construct($code = "") {
		$code = empty($code) ? $this->code : $code;
		http_response_code($code);
	}

}