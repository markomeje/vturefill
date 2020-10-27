<?php 

namespace Framework\Models;
use Application\Core\{Model, Paystacks};
use Application\Library\{Validate, Database, Generate, Session,  Authentication};
use Framework\Models\{Users};
use Framework\Models\Components\Pagination;


class Payments extends Model {

    private static $table = "payments";
    private static $minimumPayment = 1000;

	public function __construct() {
		parent::__construct();
	}

	public static function addPayment() {
		$data = ["user" => self::get("user"), "amount" => self::get("amount"), "email" => self::get("email")];
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
		    if (strtolower($transaction->data->status) !== "success") throw new Exception("Error Processing Request", 1);
		    $database = Database::connect();
		    $database->beginTransaction();
		    $result = self::getPaymentByReference(["status" => "initialized", "reference" => $reference]);
			$fields = ["status" => "paid", "reference" => $reference, "user" => $result->user, "email" => $result->email];
			if (self::updatePaymentStatus($fields) === true) return Funds::topUpFund(["user" => $fields["user"], "email" => $fields["email"], "amount" => $result->amount]) === true ? $database->commit() : false ;
            return false;
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
			$database->prepare("SELECT * FROM {$table} WHERE reference = :reference AND status = :status LIMIT 1");
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