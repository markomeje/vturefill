<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Json};
use VTURefill\Gateways\Clubkonnect;
use VTURefill\Library\{Validate, Database};


class Orders extends Model {

    private static $table = 'orders';
    public static $orderStatus = ['completed', 'pending'];

	public function __construct() {
		parent::__construct();
	}

	public static function orderData($data) {
		if (empty($data['network'])) {
			return ['status' => 0, 'message' => 'Invalid mobile network'];
		}elseif(empty($data['phone'])) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif (empty($data['plan'])) {
			return ['status' => 0, 'message' => 'Invalid data plan'];
		}elseif (empty($data['user'])) {
			return ['status' => 0, 'message' => 'Invalid user reference'];
		}elseif(empty($data['amount'])) {
			return ['status' => 0, 'message' => 'Invalid amount'];
		}
        try {
        	$where = ['user' => $data['user'], 'amount' => $data['amount']];
			if (!Funds::isSufficientFunds($where)) return ['status' => 0, 'message' => 'Insufficient Funds'];
			Funds::debitFund($where);
			$user = User::getById($data['user']);

			if(strtolower((Networks::getNetworkByCode($data['network']))->status) === 'manual') {
				$order = self::addOrder(array_merge(['status' => 'pending', 'type' => 'manual'], $data));
				return ['status' => 1, 'message' => 'Order pending',  'user' => $user, 'order' => self::getOrderById($order['id'])];
			}

            $response = RefillGateway::topUpAirtime(['network' => $data['network'], 'phone' => $data['phone'], 'amount' => $data['amount'], 'reference' => Generate::string()]);
			$fund = Funds::getFund($data['user']);
			$refundAmount = $fund->amount + $data['amount'];
            $apiStatusCode = isset($response['code']) ? $response['code'] : 0;
          
			if ($apiStatusCode === 103) {
		        Funds::creditFund($where);
		        $order = self::addOrder(array_merge(['status' => 'cancelled', 'type' => 'normal'], $data));
		        return ['status' => 2, 'message' => 'Order Cancelled',  'user' => $user, 'order' => self::getOrderById($order['id'])];

			}else if($apiStatusCode === 100){
				$order = self::addOrder(array_merge(['status' => 'success', 'type' => 'normal'], $data));
		        return ['status' => 1, 'message' => 'Order Successfull',  'user' => $user, 'order' => self::getOrderById($order['id'])];

			}else {
				Funds::creditFund($where);
		        $order = self::addOrder(array_merge(['status' => 'failed', 'type' => 'normal'], $data));
		        return ['status' => 0, 'message' => 'Order Failed',  'user' => $user, 'order' => self::getOrderById($order['id'])];
			}
        } catch (Exception $error) {
        	Logger::log('ADDING ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			Funds::creditFund($where);
		    $order = self::addOrder(array_merge(['status' => 'failed', 'type' => 'normal'], $data));
		    return ['status' => 0, 'message' => 'Order Failed',  'user' => $user, 'order' => self::getOrderById($order['id'])];
        }
			

	}

	public static function addOrder($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, network, plan, phone, type, status, amount) VALUES (:user, :network, :plan, :phone, :type, :status, :amount)");
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

	public static function getOrderById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(['id' => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log('GETTING ORDER BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

