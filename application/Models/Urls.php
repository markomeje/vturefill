<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate};


class Urls extends Model {

    private static $table = "urls";
    public static $urlStatus = ["active", "inactive"];

	public function __construct() {
		parent::__construct();
	}

	public static function addUrl() {
		$posted = ["status" => self::post("status"), "url" => self::post("url")];
		if (empty($posted["url"]) || !Validate::url($posted["url"])) {
			return ["status" => "invalid-url"];
		}elseif (empty($posted["status"])) {
			return ["status" => "invalid-status"];
		}

		try {
			$database = Database::instance();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (url, status) VALUES(:url, $status)");
			$database->execute($posted);
		} catch (Exception $error) {
			Logger::log("USER LOGIN ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

}

