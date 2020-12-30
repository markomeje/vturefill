<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Json, Logger, Help};
use VTURefill\Gateways\MobileairtimengGateway;
use VTURefill\Library\{Validate, Database, Generate};
use \Exception;


class Airtime extends Model {

    private static $table = 'airtime';

	public function __construct() {
		parent::__construct();
	}

	public static function airtimeTopUp($data) {
		if (empty($data['network'])) {
			return ['status' => 0, 'message' => 'Invalid mobile network'];
		}elseif(empty($data['phone'])) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif (empty($data['user'])) {
			return ['status' => 0, 'message' => 'Invalid User'];
		}elseif(empty($data['amount'])) {
			return ['status' => 0, 'message' => 'Invalid amount'];
		}

        try {
        	$user = Users::getById($data['user']);
        	if(empty($user)) return ['status' => 0, 'message' => 'User not found'];
        	$funds = Funds::getFund($user->id);
        	$level = Levels::getDiscountByLevel($funds->level);
        	$discount = Help::getPercentValue((float)$level->discount, $data['amount']);
        	$discountAmount = $data['amount'] - $discount;

        	$where = ['user' => $user->id, 'amount' => $discountAmount];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
             
            $response = MobileairtimengGateway::topUpAirtime(['network' => $data['network'], 'phone' => $data['phone'], 'amount' => $data['amount'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
            $details = ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'funds' => $funds->amount, 'level' => $funds->level];

			if($apiStatusCode !== 100) {
			    throw new Exception('Airtime Purchase Failed For User ' . $user->id);
			}else {
				$data['amount'] = $discountAmount;
				$order = self::addUserAirtimeOrder(array_merge(['status' => 'success', 'reference' => $reference], $data));
			    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $details, 'order' => self::getAirtimeOrderById($order['id'])];
			}
        } catch (Exception $error) {
        	Logger::log('ADDING USER AIRTIME ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
			$data['amount'] = $discountAmount;
		    $order = self::addUserAirtimeOrder(array_merge(['status' => 'failed', 'reference' => $reference], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $details, 'order' => self::getAirtimeOrderById($order['id'])];
        }
	}

	public static function addUserAirtimeOrder($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, network, phone, status, amount, reference) VALUES (:user, :network,  :phone, :status,  :amount, :reference)");
			$database->execute($fields);
			return ['count' => $database->rowCount(), 'id' => $database->lastInsertId()];
		} catch (Exception $error) {
			Logger::log('ADDING USER AIRTIME ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getUserAirtimeAllOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ALL AIRTIME ORDERS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllUserAirtimeOrders($user) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE user = :user ORDER BY date DESC");
			$database->execute(['user' => $user]);
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ORDER BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAirtimeOrderById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(['id' => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log('GETTING AIRTIME ORDER BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllAirtimeOrders() {}

}

