<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate, Database};
use \Exception;
use VTURefill\Gateways\MobileairtimengGateway;


class Tv extends Model {

    private static $table = 'tv';

	public function __construct() {
		parent::__construct();
	}

	public static function getAllProducts() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT {$table}.id, {$table}.product as name, {$table}.category, {$table}.date, categories.category as family FROM {$table}, categories WHERE {$table}.category = categories.id ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL PRODUCTS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function validateMeterNumber($data) {
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
			return false;
		}
	}

	public static function getStartimesPlans() {}

}

