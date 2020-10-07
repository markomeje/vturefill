<?php

namespace Application\Library;

class Validate {

	public static function escape($input) {
		$input = trim(strip_tags($input));
		return htmlentities(stripslashes($input), ENT_QUOTES);
	}

	public static function email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function length($input, $length) {
		return (mb_strlen($input, 'utf8') === (int)$length);
	}

    public static function range($input, $minimum, $maximum){
    	$range = mb_strlen($input, 'utf8');
        return ($range >= (int)$minimum && $range <= (int)$maximum) ? true : false;
    }

    private static function integer($value){
        return filter_var($value, FILTER_VALIDATE_INT);
    }

}