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
			return ['airtime' => Airtime::getAllUserAirtimeOrders($user), 'payments' => Payments::getAllUserPayments($user), 'tv' => Tv::getAllUserTvOrders($user), 'data' => Data::getAllUserDataOrders($user), 'electricity' => Electricity::getAllUserElectricityOrders($user)];
		} catch (Exception $error) {
			Logger::log('GETTING ALL USER TRANSACTIONS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return ['status' => 0, 'message' => 'Try again.'];
		}
	}

}

