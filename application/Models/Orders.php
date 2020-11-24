<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Json};
use VTURefill\Gateways\Clubkonnect;
use VTURefill\Library\{Validate, Database};
use VTURefill\Models\{Networks, Funds};


class Orders extends Model {

    private static $table = 'orders';
    public static $orderStatus = ['completed', 'pending'];

	public function __construct() {
		parent::__construct();
	}

	public static function orderData($data) {
		if (empty($data['network'])) {
			return ['status' => 0, 'message' => 'Invalid mobile network'];
		}elseif(empty($data['phone']) || !Validate::length($data['phone'], 11)) {
			return ['status' => 0, 'message' => 'Invalid phone number'];
		}elseif (empty($data['plan'])) {
			return ['status' => 0, 'message' => 'Invalid data plan'];
		}elseif (empty($data['id'])) {
			return ['status' => 0, 'message' => 'Invalid user'];
		}
        
        $user = User::getById($data['id']);
        if (empty($user)) return ['status' => 0, 'message' => 'Invalid user'];
		$network = Networks::getNetworkById($data['network']);
		if (empty($network)) {
			return ['status' => 0, 'message' => 'Invalid network code'];
		}elseif(isset($network->status) && strtolower($network->status) === 'manual') {
			$fields = array_merge(['status' => 'pending', 'type' => 'manual'], $data);
			return self::addOrder($fields) === true ? ['status' => 1, 'message' => 'success'] : ['status' => 0, 'message' => 'error', 'user' => $user];
		}else {
            $response = Clubkonnect::buyDataBundle($data);
			$api = is_string($response) ? Json::decode($response) : [];
			return ['api' => $api, 'code' => http_response_code()];
			// $response = $clubkonnect->apiResponses($api->status);
			// if(isset($response['code']) && $response['code'] === 2) {
			// 	return ['status' => 'success'];
			// }else {
			// 	return ['status' => 'error'];
			// }
		}

	}

	public static function addOrder($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare('INSERT INTO {$table} (order, user, network, plan, phone, type status) VALUES(:order, :user, :network, :plan, :phone, :type :status)');
			$database->execute($fields);
			return ($database->rowCount() > 0) ? true : false;
		} catch (Exception $error) {
			Logger::log('ADDING ORDER ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllOrdersCount() {}

	public static function getAllOrders() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare('SELECT * FROM {$table} ORDER BY date DESC');
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
			$database->prepare('SELECT * FROM {$table} WHERE id = :id LIMIT 1');
			$database->execute();
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log('GETTING ORDER BY ID ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

