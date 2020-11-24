<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Paystacks};
use VTURefill\Library\{Validate, Database, Generate, Session,  Authentication};
use VTURefill\Models\{Users};
use VTURefill\Models\Components\Pagination;


class Payments extends Model {

    private static $table = "payments";
    private static $minimumPayment = 1000;

	public function __construct() {
		parent::__construct();
	}

	public static function addPayment($data) {
		if (empty($data["user"]) || empty(Users::getUserById($data["user"]))) {
			return ["status" => 0, "message" => "User does not exists"];
		}elseif(empty($data["amount"])) {
			return ["status" => 0, "message" => "Invalid Payment amount"];
		}elseif($data["amount"] < self::$minimumPayment) {
			return ["status" => 0, "message" => "Minimum amount error"];
		}elseif (empty($data["email"]) || Users::emailExists($data["email"]) === false) {
			return ["status" => 0, "message" => "Invalid user email"];
		}

		try{
	    	$paystack = new Paystacks;
	    	$transaction = $paystack->initialize(["amount" => $data["amount"] * 100, "email" => $data["email"], "reference" => Generate::hash()]);
	    	$fields = ["reference" => $transaction->data->reference, "status" => "initialized"];
	    	$merged = array_merge($data, $fields);
    		$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (user, amount, email, reference, status) VALUES(:user, :amount, :email, :reference, :status)");
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => 1, "redirect" => $transaction->data->authorization_url] : ["status" => "error"];
	    } catch(Exception $error){
	        Logger::log("PAYSTACK PAYMENT ERROR", $error->getMessage(), __FILE__, __LINE__);
        	return ["status" => "error"];
	    }
	}

	public static function verifyPayment() {
		try {
			$paystack = new Paystacks;
			$reference = self::get("reference");
		    $transaction = $paystack->verify($reference);
		    if (strtolower($transaction->data->status) !== "success") throw new Exception("Error Verifying Paystack Transaction");
		    $database = Database::connect();
		    $database->beginTransaction();
		    $payment = self::getPaymentByReference(["reference" => $reference]);
			$fields = ["status" => "paid", "reference" => $reference, "user" => $payment->user, "email" => $payment->email];
			if (self::updatePaymentStatus($fields) === true) {
				$data = ["user" => $fields["user"], "amount" => $payment->amount];
			    if (!Funds::topUpFund($data)) throw new Exception("Error Toping Up Fund For User ". $data['user']);
			}
			$database->commit();
            return true;
		} catch (Exception $error) {
			$database->rollback();
			Logger::log("VERIFYING PAYMENT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function updatePaymentStatus($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET status = :status WHERE user = :user AND email = :email AND reference = :reference LIMIT 1");
			$database->execute($fields);
			return $database->rowCount() > 0 ? true : false;
		} catch (Exception $error) {
			Logger::log("UPDATING PAYMENT STATUS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}



	public static function getPaymentByReference($fields) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE reference = :reference LIMIT 1");
			$database->execute($fields);
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
			$database->prepare("SELECT * FROM {$table} ORDER BY date DESC LIMIT {$limit} OFFSET {$offset}");
			$database->execute();
            return ["allPayments" => $database->fetchAll(), "pagination" => $pagination, "totalCount" => $pagination->totalCount];
		} catch (Exception $error) {
			Logger::log("GETTING ALL PAYMENT ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}