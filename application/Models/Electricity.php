<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Database, Generate};
use \Exception;
use VTURefill\Gateways\MobileairtimengGateway;


class Electricity extends Model {

    private static $table = 'electricity';

	public function __construct() {
		parent::__construct();
	}

	public static function getAllElectricityOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL ELECTRICITY ORDERS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function validateMeterNumber($data) {
		if (empty($data['service'])) {
			return ['status' => 0, 'message' => 'Invalid service'];
		}elseif (empty($data['meterno'])) {
			return ['status' => 0, 'message' => 'Invalid meter number'];
		}

		try {
			$response = MobileairtimengGateway::validateElectricityMeterNumber($data);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
			return $apiStatusCode === 100 ? ['status' => 1, 'message' => 'successfull', 'details' => $response] : ['status' => 0, 'message' => 'invalid', 'details' => $response === false ? ['code' => 101, 'message' => 'Invalid Credentials'] : $response];
		} catch (Exception $error) {
			Logger::log("VALIDATING ELECTRICITY METER NUMBER ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function buyElectricity($data) {
		if (empty($data['service'])) {
			return ['status' => 0, 'message' => 'Empty service'];
		}elseif(empty($data['meterno'])) {
			return ['status' => 0, 'message' => 'Empty meter number'];
		}elseif (empty($data['mtype']) || !in_array($data['mtype'], [1, 0])) {
			return ['status' => 0, 'message' => 'Invalid meter number'];
		}elseif (empty($data['user'])) {
			return ['status' => 0, 'message' => 'Invalid User'];
		}elseif(empty($data['amount'])) {
			return ['status' => 0, 'message' => 'Invalid amount'];
		}

        try {
        	$database = Database::connect();
        	$database->beginTransaction();
        	$user = Users::getById($data['user']);
        	if(empty($user)) return ['status' => 0, 'message' => 'User not found'];
        	$where = ['user' => $user->id, 'amount' => $amount];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
            $orders = self::getUserElectricityOrders($user->id);
            $funds = Funds::getFund($user->id);
             
            $response = MobileairtimengGateway::buyElectricity(['service' => $data['service'], 'meterno' => $data['meterno'], 'mtype' => $data['mtype'], 'amount' => $data['amount'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
          
			if($apiStatusCode !== 100) throw new Exception("Electricity Recharge Failed For User " . $user->id);
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, service, meterno, mtype, status, amount, reference) VALUES (:user, :service,  :meterno, :mtype, :status,  :amount, :reference)");
			$fields = array_merge($data, ['reference' => $reference, 'status' => 'success']);
			$database->execute($fields);
			$database->commit();

		    return $database->rowCount() > 0 ? ['status' => 1, 'message' => 'Order Successfull',  'user' => $user, 'orders' => $orders, 'funds' => $funds] : throw new Exception("Electricity Recharge Failed For User " . $user->id);
        } catch (Exception $error) {
        	$database->rollback();
        	Logger::log('ADDING ELECTRICITY ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $user, 'orders' => $orders, 'funds' => $funds];
        }
	}

	public static function getUserElectricityOrders($user) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE user = :user ORDER BY date DESC");
			$database->execute(['user' => $user]);
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING USER ELECTRICITY ORDERS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

