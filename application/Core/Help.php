<?php

namespace Application\Core;


class Help {


	public static function getFiatCurrencies() {
		return ["NGN", "USD", "EUR"];
	}

	public static function getCryptoCurrencies() {
		return ["BTC" => "Bitcoin", "BCH" => "Bitcoin Cash", "LTC" => "Litecoin", "ETH" => "Ether", "TRX" => "TRON", "LTCT" => "Litecoin Testnet"];
	}

	public static function getMonthsOfYear() {
		return ["01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December"];
	}

	public static function limitStringLength($string, $length = "") {
		$dots = " . . .";
		$length = empty($length) ? 25 : $length;
		if (strlen($string) > $length) {
			$string = substr($string, 0, $length);
			return $string.$dots;
		}
        return $string;
	}

	public static function timeAgo($timestamp){
		$time_ago        = strtotime($timestamp);
		$current_time    = time();
		$time_difference = $current_time - $time_ago;
		$seconds         = $time_difference;

		$minutes = round($seconds / 60); // value 60 is seconds
		$hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks   = round($seconds / 604800); // 7*24*60*60;
		$months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
		$years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

	    if ($seconds <= 60){

	        return "Just Now";

	    } else if ($minutes <= 60){

		    if ($minutes == 1){
		        return "one minute ago";
		    } else {
		        return "$minutes minutes ago";

		    }

	    } else if ($hours <= 24){

		    if ($hours == 1){
		        return "an hour ago";
		    } else {
		        return "$hours hrs ago";

		    }

	    } else if ($days <= 7){

		    if ($days == 1){
		        return "yesterday";
		    } else {
		        return "$days days ago";

		    }

	    } else if ($weeks <= 4.3){

		    if ($weeks == 1){
		      return "a week ago";
		    } else {
		      return "$weeks weeks ago";

		    }

	    } else if ($months <= 12){

		    if ($months == 1){
		      return "a month ago";
		    } else {
		      return "$months months ago";

		    }

	    } else {

		    if ($years == 1){
		      return "one year ago";
		    } else {
		      return "$years years ago";

		    }
	    }
	}

	public static function getAge($birthdate) {
		$birthyear = date("Y", strtotime($birthdate));
		$age = (date("Y") - $birthyear);
		return $age;
	}

	public static function calculatePercent($top, $bottom) {
		$percent = (($top/$bottom) * 100);
		return round($percent);
	}

	public static function getPercentValue($percent, $number) {
		$value = (($percent/100) * $number);
		return round($value);
	}

	public static function getNigerianStates() {
		return ["Abia", "Abuja", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno", "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", "Imo", "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nasarawa", "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara"];
	}

	public static function getRelationshipStatus() {
		return ["Married", "Widowed", "Single", "Divorced"];
	}

	public static function formatDatetime($datetime = "") {
		return (empty($datetime) || $datetime === "") ? date("F j, Y, g:i a") : date("F j, Y, g:i a", strtotime($datetime));
	}

	public static function formatDate($date = "") {
		return (empty($date) || $date === "") ? date("F j, Y") : date("F j, Y", strtotime($date));
	}

	public static function getWeeksOfAMonth($month, $year) {
		$numberOfDays = date("t", mktime(0, 0, 0, $month, 1, $year));
		$lastDay = date("t", mktime(0, 0, 0, $month, 1, $year));
		$numberOfWeeks = 0;
		$countOfWeeks = 0;
		while ($numberOfWeeks < $lastDay) {
			$numberOfWeeks += 7;
			$countOfWeeks ++;
		}
		return $countOfWeeks;
	}

	public static function getGenders() {
		return ["Male", "Female"];
	}

}
