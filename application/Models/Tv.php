<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger};
use VTURefill\Library\{Validate, Database, Generate};
use \Exception;
use VTURefill\Gateways\MobileairtimengGateway;


class Tv extends Model {

    private static $table = 'tv';

	public function __construct() {
		parent::__construct();
	}

	public static function validateTvMeterNumber($data) {
		if (empty($data['bill'])) {
			return ['status' => 0, 'message' => 'Invalid bill'];
		}elseif (empty($data['smartno'])) {
			return ['status' => 0, 'message' => 'Invalid smart number'];
		}

		try {
			$response = MobileairtimengGateway::validateTvMeterNumber($data);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
			return $apiStatusCode === 100 ? ['status' => 1, 'message' => 'successfull', 'details' => $response] : ['status' => 0, 'message' => 'invalid', 'details' => $response];
		} catch (Exception $error) {
			Logger::log("VALIDATING TV METER NUMBER ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ['status' => 0, 'message' => 'invalid', 'details' => $response];
		}
	}

	public static function subscribeGotvDstv($data) {
		if (empty($data['phone'])) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif (empty($data['amount'])) {
			return ['status' => 0, 'message' => 'Invalid amount'];
		}elseif (empty($data['smartno'])) {
			return ['status' => 0, 'message' => 'Invalid smart number'];
		}elseif (empty($data['customer'])) {
			return ['status' => 0, 'message' => 'Invalid customer'];
		}elseif (empty($data['invoice'])) {
			return ['status' => 0, 'message' => 'Invalid invoice'];
		}elseif (empty($data['billtype']) || !in_array(strtolower($data['billtype']), ['dstv', 'gotv'])) {
			return ['status' => 0, 'message' => 'Invalid bill type. Bill type must be either gotv or dstv.'];
		}elseif (empty($data['customernumber'])) {
			return ['status' => 0, 'message' => 'Invalid customer number'];
		}elseif (empty($data['user'])) {
			return ['status' => 0, 'message' => 'Invalid user'];
		}

		try {
			$user = Users::getById($data['user']);
        	if(empty($user)) return ['status' => 0, 'message' => 'User not found'];
            $funds = Funds::getFund($user->id);
        	$where = ['user' => $user->id, 'amount' => $data['amount']];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
             
            $response = MobileairtimengGateway::subscribeGotvDstv(['phone' => $data['phone'], 'smartno' => $data['smartno'], 'customer' => $data['customer'], 'amount' => $data['amount'], 'invoice' => $data['invoice'], 'billtype' => $data['billtype'], 'customernumber' => $data['customernumber'], 'reference' => $reference]);

            $apiStatusCode = isset($response->code) ? $response->code : 0;
            $details = ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'funds' => $funds->amount, 'level' => $funds->level];

			if($apiStatusCode !== 100) {
			    throw new Exception(ucfirst($data['billtype']).' Purchase Failed For User ' . $user->id . " With Status Code " . $apiStatusCode);
			}else {
				$order = self::addUserTvOrder(array_merge(['status' => 'success', 'reference' => $reference], $data));
			    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $details, 'order' => self::getTvOrderById($order['id'])];
			}
        } catch (Exception $error) {
        	Logger::log('PURCHASING '. strtoupper($data['billtype']) .' ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
		    $order = self::addUserTvOrder(array_merge(['status' => 'failed', 'reference' => $reference], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $details, 'order' => self::getTvOrderById($order['id'])];
        }
	}

	public static function subscribeStartimes($data) {
		if (empty($data['phone'])) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif (empty($data['amount'])) {
			return ['status' => 0, 'message' => 'Invalid amount'];
		}elseif (empty($data['smartno'])) {
			return ['status' => 0, 'message' => 'Invalid smart number'];
		}elseif (empty($data['customer'])) {
			return ['status' => 0, 'message' => 'Invalid customer'];
		}elseif (empty($data['invoice'])) {
			return ['status' => 0, 'message' => 'Invalid invoice'];
		}elseif (empty($data['customernumber'])) {
			return ['status' => 0, 'message' => 'Invalid customer number'];
		}elseif (empty($data['user'])) {
			return ['status' => 0, 'message' => 'Invalid user'];
		}

		try {
			$user = Users::getById($data['user']);
        	if(empty($user)) return ['status' => 0, 'message' => 'User not found'];
            $funds = Funds::getFund($user->id);
        	$where = ['user' => $user->id, 'amount' => $data['amount']];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
             
            $response = MobileairtimengGateway::subscribeStartimes(['phone' => $data['phone'], 'smartno' => $data['smartno'], 'amount' => $data['amount'], 'reference' => $reference]);

            $apiStatusCode = isset($response->code) ? $response->code : 0;
            $details = ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'funds' => $funds->amount, 'level' => $funds->level];

			if($apiStatusCode === 100) {
				$order = self::addUserTvOrder(array_merge(['status' => 'success', 'reference' => $reference], $data));
			    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $details, 'order' => self::getTvOrderById($order['id'])];
			}else {
				throw new Exception('Startimes Purchase Failed For User ' . $user->id . ' With Status Code ' . $apiStatusCode);
			}
        } catch (Exception $error) {
        	Logger::log('PURCHASING STARTIMES ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
		    $order = self::addUserTvOrder(array_merge(['status' => 'failed', 'reference' => $reference], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $details, 'order' => self::getTvOrderById($order['id'])];
        }
	}

	public static function addUserTvOrder($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, amount, phone, smartno, customer, invoice, billtype, customernumber, status, reference) VALUES (:user, :amount,  :phone, :smartno, :customer, :invoice, :billtype, :customernumber, :status, :reference)");
			$database->execute($fields);
			return ['count' => $database->rowCount(), 'id' => $database->lastInsertId()];
		} catch (Exception $error) {
			Logger::log('ADDING USER TV ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getUserTvAllOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ALL TV ORDERS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllUserTvOrders($user) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE user = :user ORDER BY date DESC");
			$database->execute(['user' => $user]);
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ALL USER TV ORDERS BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getTvOrderById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(['id' => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log('GETTING TV ORDER BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

