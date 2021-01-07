<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger};
use VTURefill\Library\{Validate, Database, Generate, Session,  Authentication};
use VTURefill\Models\Components\Pagination;
use VTURefill\Gateways\{PaystackGateway};
use \Exception;


class Payments extends Model {

    private static $table = "payments";
    private static $minimumPayment = 100;

	public function __construct() {
		parent::__construct();
	}

	public static function makePayment($data) {
		$user = Users::getById($data["user"]);
		if (empty($data["user"]) || empty($user)) {
			return ["status" => 0, "message" => "User does not exists"];
		}elseif(empty($data["amount"])) {
			return ["status" => 0, "message" => "Invalid Payment amount"];
		}elseif($data["amount"] < self::$minimumPayment) {
			return ["status" => 0, "message" => "Minimum amount is " . self::$minimumPayment];
		}elseif(empty($data["level"])) {
			return ["status" => 0, "message" => "Level is required"];
		}

		try{
			$email = empty($user->email) ? '' : $user->email;
	    	$transaction = (new PaystackGateway)->initialize(["amount" => $data["amount"] * 100, "email" => $email, "reference" => Generate::hash()]);
    		$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, amount, reference, status, level) VALUES(:user, :amount, :reference, :status, :level)");
			$merged = array_merge($data, ["reference" => $transaction->data->reference, "status" => "initialized"]);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => 1, "redirect" => $transaction->data->authorization_url] : ["status" => 0, 'message' => 'Payment Failed. Try Again.'];
	    } catch(Exception $error){
	        Logger::log("PAYMENT ERROR", $error->getMessage(), __FILE__, __LINE__);
        	return ["status" => "error"];
	    }
	}

	public static function verifyPayment($reference) {
		try {
		    $transaction = (new PaystackGateway)->verify($reference);
		    if (strtolower($transaction->data->status) !== 'success') throw new Exception("Error Verifying Paystack Transaction");
		    $payment = self::getPaymentByReference($reference);
		    $user = empty($payment->user) ? 0 : $payment->user;
		    $amount = empty($payment->amount) ? 0 : $payment->amount;

			if (!self::updatePaymentStatus(['status' => 'paid', 'reference' => $reference, 'user' => $user])) throw new Exception('Error Updating Payment Status For User '. $user);

			Funds::creditFund(['user' => $user, 'amount' => $amount]);
			$funds = empty(Funds::getFund($user)) ? 0 : Funds::getFund($user);
            return ['status' => 1, 'message' => 'Payment Verification Successfull', 'funds' => $funds];
		} catch (Exception $error) {
			Logger::log("VERIFYING PAYMENT ERROR", $error->getMessage(), __FILE__, __LINE__);
			$funds = empty(Funds::getFund($user)) ? 0 : Funds::getFund($user);
			return ['status' => 0, 'message' => 'Payment Verification Failed', 'funds' => $funds];
		}
	}

	public static function updatePaymentStatus($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET status = :status WHERE user = :user AND reference = :reference LIMIT 1");
			$database->execute($fields);
			return $database->rowCount() > 0;
		} catch (Exception $error) {
			Logger::log("UPDATING PAYMENT STATUS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}



	public static function getPaymentByReference($reference) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE reference = :reference LIMIT 1");
			$database->execute(['reference' => $reference]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING PAYMENT DATA BY REFERENCE ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllPayments($pageNumber = 0) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$pagination = Pagination::paginate("SELECT * FROM {$table}", [], $pageNumber);
            $offset = $pagination->getOffset();
            $limit = $pagination->itemsPerPage;
			$database->prepare("SELECT {$table}.*, users.email, users.username FROM {$table}, users WHERE {$table}.user = users.id ORDER BY date DESC LIMIT {$limit} OFFSET {$offset}");
			$database->execute();
            return ["allPayments" => $database->fetchAll(), "pagination" => $pagination, "count" => $pagination->totalCount];
		} catch (Exception $error) {
			Logger::log("GETTING ALL PAYMENT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getAllUserPayments($user) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE user = :user ORDER BY date DESC");
			$database->execute(['user' => $user]);
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log('GETTING ALL USER PAYMENTS ERROR', $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}


}