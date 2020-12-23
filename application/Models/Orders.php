<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Json, Logger};
use VTURefill\Gateways\MobileairtimengGateway;
use VTURefill\Library\{Validate, Database, Generate};
use \Exception;


class Orders extends Model {

    private static $table = 'orders';
    public static $orderStatus = ['completed', 'pending'];

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
        	$amount = self::getOrderDiscountAmount(['user' => $user->id, 'amount' => $data['amount']]);

        	$where = ['user' => $user->id, 'amount' => $amount];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
             
            $response = MobileairtimengGateway::topUpAirtime(['network' => $data['network'], 'phone' => $data['phone'], 'amount' => $data['amount'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
            $apiUserRef = isset($response->user_ref) ? $response->user_ref : $reference;
          
			if($apiStatusCode !== 100) throw new Exception("Airtime Purchase Failed For User " . $data['user'], 1);
			$data['amount'] = $amount;
			self::addOrder(array_merge(['status' => 'success', 'type' => 'normal', 'reference' => $apiUserRef, 'category' => 'data'], $data));
		    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
        } catch (Exception $error) {
        	Logger::log('ADDING ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
			$data['amount'] = $amount;
		    self::addOrder(array_merge(['status' => 'failed', 'type' => 'normal', 'reference' => $apiUserRef, 'category' => 'data'], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
        }
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
        	$amount = self::getOrderDiscountAmount(['user' => $user->id, 'amount' => $data['amount']]);

        	$where = ['user' => $user->id, 'amount' => $amount];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
            $data['amount'] = $amount;

			if(strtolower((Networks::getNetworkByCode($data['network']))->status) === 'manual') {
				self::addOrder(array_merge(['status' => 'pending', 'type' => 'manual', 'reference' => $reference, 'category' => 'data'], $data));
				return ['status' => 1, 'message' => 'Order pending',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
			}
             
            $response = MobileairtimengGateway::mtnSmeData(['network' => $data['network'], 'phone' => $data['phone'], 'datasize' => $data['plan'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
            $apiUserRef = isset($response->user_ref) ? $response->user_ref : $reference;
            
			if($apiStatusCode !== 100) throw new Exception("MTN SME Data Purchase Failed For User " . $data['user'], 1);
			$order = self::addOrder(array_merge(['status' => 'success', 'type' => 'normal', 'reference' => $apiUserRef, 'category' => 'data'], $data));
		    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
        } catch (Exception $error) {
        	Logger::log('ADDING ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
			$data['amount'] = $amount;
		    self::addOrder(array_merge(['status' => 'failed', 'type' => 'normal', 'reference' => $apiUserRef, 'category' => 'data'], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
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
        	$amount = self::getOrderDiscountAmount(['user' => $user->id, 'amount' => $data['amount']]);

        	$where = ['user' => $user->id, 'amount' => $amount];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
            $reference = Generate::string(25);
            $data['amount'] = $amount;

			if(strtolower((Networks::getNetworkByCode($data['network']))->status) === 'manual') {
				self::addOrder(array_merge(['status' => 'pending', 'type' => 'manual', 'reference' => $reference, 'category' => 'data'], $data));
				return ['status' => 1, 'message' => 'Order pending',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
			}
             
            $response = MobileairtimengGateway::directTopUp(['network' => $data['network'], 'phone' => $data['phone'], 'reference' => $reference]);
            $apiStatusCode = isset($response->code) ? $response->code : 0;
            $apiUserRef = isset($response->user_ref) ? $response->user_ref : $reference;

			if($apiStatusCode !== 100) throw new Exception("MTN SME Data Purchase Failed For User " . $data['user'], 1);
			$order = self::addOrder(array_merge(['status' => 'success', 'type' => 'normal', 'reference' => $apiUserRef, 'category' => 'data'], $data));
		    return ['status' => 1, 'message' => 'Order Successfull',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
        } catch (Exception $error) {
        	Logger::log('ADDING ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
			$data['amount'] = $amount;
		    self::addOrder(array_merge(['status' => 'failed', 'type' => 'normal', 'reference' => $apiUserRef, 'category' => 'data'], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $user, 'order' => self::getOrder($data['user']), 'funds' => Funds::getFund($user->id)];
        }
	}

	public static function addOrder($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, network, phone, type, status, plan, amount, reference, category) VALUES (:user, :network,  :phone, :type, :status, :plan,  :amount, :reference, :category)");
			$database->execute($fields);
			return ['count' => $database->rowCount(), 'id' => $database->lastInsertId()];
		} catch (Exception $error) {
			Logger::log('ADDING ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ALL ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getOrder($user) {
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

	public static function getOrderDiscountAmount($data) {
		$fund = Funds::getFund($data['user']);
        $level = Levels::getDiscountByLevel($fund->level);
        $discount = (float)$level->discount * $data['amount'];
		$discountedAmount = $data['amount'] - $discount;
		return $discountedAmount;
	}

}

