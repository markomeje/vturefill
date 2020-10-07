<?php

namespace Application\Core;


class Help {


	public static function getFiatCurrencies() {
		return ["NGN", "USD", "EUR"];
	}

    public static function redirect($location) {
        if (!headers_sent()) {
            header('Location: '.DOMAIN.$location);
        }else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.DOMAIN.$location.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
            echo '</noscript>';
            exit;
        }
    }

	public static function getCryptoCurrencies() {
		return ["BTC" => "Bitcoin", "BCH" => "Bitcoin Cash", "LTC" => "Litecoin", "ETH" => "Ether", "TRX" => "TRON", "LTCT" => "Litecoin Testnet"];
	}

	public static function getAllCountries() {
		return ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Democratic Republic of Congo", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea", "Korea Democratic People's Republic", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];
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
