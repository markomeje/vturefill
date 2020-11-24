<?php

namespace VTURefill\Exceptions;
use \Exception;


class ParserException extends Exception {

	public $message = 'Internal server error due to a misconfiguration';
	
	public $code = 500;

}