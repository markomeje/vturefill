<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Json, Logger, Help};
use VTURefill\Gateways\MobileairtimengGateway;
use VTURefill\Library\{Validate, Database, Generate};
use \Exception;


class Data extends Model {

    private static $table = 'data';

	public function __construct() {
		parent::__construct();
	}

	public static function mtnSmeData($data) {
		if (empty($data['network'])) {
			return ['status' => 0, 'message' => 'Invalid mobile network'];
		}elseif(empty($data['phone'])) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif (empty($data['user'])) {
			return ['status' => 0, 'message' => 'Invalid User'];
		}elseif(empty($data['plan'])) {
			return ['status' => 0, 'message' => 'Invalid plan'];
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
            $data['amount'] = $discountAmount;
            $details = ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'funds' => $funds->amount, 'level' => $funds->level];

			if(strtolower((Networks::getNetworkByCode($data['network']))->status) === 'manual') {
				$order = self::addUserDataOrder(array_merge(['status' => 'pending', 'type' => 'manual', 'reference' => $reference, 'category' => 'sme'], $data));
				return ['status' => 1, 'message' => 'Order pending',  'user' => $details, 'order' => self::getDataOrderById($order['id'])];
			}
             
            $response = MobileairtimengGateway::mtnSmeData(['network' => $data['network'], 'phone' => $data['phone'], 'datasize' => $data['plan'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
            
			if($apiStatusCode !== 100) { throw new Exception("MTN SME Data Purchase Failed For User " . $user->id);
		    }else {
		    	$order = self::addUserDataOrder(array_merge(['status' => 'success', 'type' => 'normal', 'reference' => $reference, 'category' => 'sme'], $data));
		        return ['status' => 1, 'message' => 'Order Successfull',  'user' => $details, 'order' => self::getDataOrderById($order['id'])];
		    }
			
        } catch (Exception $error) {
        	Logger::log('BUYING MTN SME DATA ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
			$data['amount'] = $discountAmount;
		    $order = self::addUserDataOrder(array_merge(['status' => 'failed', 'type' => 'normal', 'reference' => $reference, 'category' => 'sme'], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $details, 'order' => self::getDataOrderById($order['id'])];
        }
	}

	public static function directDataTopUp($data) {
		if (empty($data['network'])) {
			return ['status' => 0, 'message' => 'Invalid mobile network'];
		}elseif(empty($data['phone'])) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif(empty($data['plan'])) {
			return ['status' => 0, 'message' => 'Invalid plan'];
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
            $data['amount'] = $discountAmount;
            $details = ['id' => $user->id, 'username' => $user->username, 'email' => $user->email, 'funds' => $funds->amount, 'level' => $funds->level];

			if(strtolower((Networks::getNetworkByCode($data['network']))->status) === 'manual') {
				$order = self::addUserDataOrder(array_merge(['status' => 'pending', 'type' => 'manual', 'reference' => $reference, 'category' => 'direct'], $data));
				return ['status' => 1, 'message' => 'Order pending',  'user' => $details, 'order' => self::getDataOrderById($order['id'])];
			}
             
            $response = MobileairtimengGateway::directTopUp(['network' => $data['network'], 'phone' => $data['phone'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;

			if($apiStatusCode !== 100) throw new Exception("MTN SME Data Purchase Failed For User " . $data['user'], 1);
			$order = self::addUserDataOrder(array_merge(['status' => 'success', 'type' => 'normal', 'reference' => $reference, 'category' => 'direct'], $data));
		    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $details, 'order' => self::getDataOrderById($order['id'])];
        } catch (Exception $error) {
        	Logger::log('BUYING DIRECT DATA ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
			$data['amount'] = $discountAmount;
		    $order = self::addUserDataOrder(array_merge(['status' => 'failed', 'type' => 'normal', 'reference' => $reference, 'category' => 'direct'], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $details, 'order' => self::getDataOrderById($order['id'])];
        }
	}

	public static function addUserDataOrder($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, network, plan, phone, status, amount, type, reference, category) VALUES (:user, :network, :plan,  :phone, :status,  :amount, :type, :reference, :category)");
			$database->execute($fields);
			return ['count' => $database->rowCount(), 'id' => $database->lastInsertId()];
		} catch (Exception $error) {
			Logger::log('ADDING DATA ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllDataOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ALL DATA ORDERS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllUserDataOrders($user) {
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

	public static function getDataOrderById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(['id' => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log('GETTING DATA ORDER BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

