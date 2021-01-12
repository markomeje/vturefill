<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger};
use VTURefill\Library\{Validate};
use \Exception;


class Transactions extends Model {


	public function __construct() {
		parent::__construct();
	}



	public static function getAllUserTransactionHistory($user) {
		try {
			$result = Users::getById($user);
        	if(empty($result)) return ['status' => 0, 'message' => 'User Not Found'];
        	$airtimes = [];
        	foreach (Airtime::getAllUserAirtimeOrders($user) as $airtime) {
        		$airtime->scope = 'airtime';
                $airtimes[] = $airtime;
        	}

        	$payments = [];
        	foreach (Payments::getAllUserPayments($user) as $payment) {
        		$payment->scope = 'payments';
                $payments[] = $payment;
        	}

        	$datas = [];
        	foreach (Data::getAllUserDataOrders($user) as $data) {
        		$data->scope = 'data';
                $datas[] = $data;
        	}

        	$electricities = [];
        	foreach (Electricity::getAllUserElectricityOrders($user) as $electricity) {
        		$electricity->scope = 'electricity';
                $electricities[] = $electricity;
        	}

        	$tvs = [];
        	foreach (Tv::getAllUserTvOrders($user) as $tv) {
        		$tv->scope = 'tv';
                $tvs[] = $tv;
        	}

        	return array_merge_recursive($airtimes, $payments, $datas, $electricities, $tvs);
		} catch (Exception $error) {
			Logger::log('GETTING ALL USER TRANSACTIONS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return ['status' => 0, 'message' => 'Try again.'];
		}
	}

}

