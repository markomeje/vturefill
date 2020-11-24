<?php

namespace VTURefill\Exceptions;
use \Exception;


class RouterException extends Exception {

	public $message = 'Page Not Found';

	public $code = 404;

}