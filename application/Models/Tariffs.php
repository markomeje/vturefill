<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model, Logger, Help};
use VTURefill\Library\{Validate, Database};
use \Exception;


class Tariffs extends Model {

    private static $table = "tariffs";
    public static $tariffType = ['sme', 'direct'];

	public function __construct() {
		parent::__construct();
	}

	public static function addTariff($posted) {
		if(empty($posted["bundle"])) {
			return ["status" => "invalid-bundle"];
		}elseif (empty($posted["network"])) {
			return ["status" => "invalid-network"];
		}elseif(empty($posted["amount"])) {
			return ["status" => "invalid-amount"];
		}elseif(empty($posted["duration"])) {
			return ["status" => "invalid-duration"];
		}elseif (empty($posted["plan"])) {
			return ["status" => "invalid-plan"];
		}elseif (empty($posted["type"])) {
			return ["status" => "invalid-type"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("INSERT INTO {$table} (network, amount, duration, bundle, plan, type) VALUES(:network, :amount, :duration, :bundle, :plan, :type)");
			$database->execute($posted);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("ADDING TARIFF ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function getAllTariffs() {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT {$table}.*, networks.name, networks.code FROM {$table}, networks WHERE networks.id = {$table}.network ORDER BY date DESC");
			$database->execute();
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL TARIFFS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getTariffsByType($type) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT {$table}.*, networks.name, networks.code FROM {$table}, networks WHERE networks.id = {$table}.network AND type = :type ORDER BY date DESC");
			$database->execute(['type' => $type]);
            return $database->fetchAll();
		} catch (Exception $error) {
			Logger::log("GETTING ALL TARIFFS ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function getTariffById($id) {
		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("SELECT * FROM {$table} WHERE id = :id LIMIT 1");
			$database->execute(["id" => $id]);
            return $database->fetch();
		} catch (Exception $error) {
			Logger::log("GETTING TARIFF BY ID ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

	public static function editTariff($posted, $id) {
		if(empty($posted["bundle"])) {
			return ["status" => "invalid-bundle"];
		}elseif (empty($posted["network"])) {
			return ["status" => "invalid-network"];
		}elseif(empty($posted["amount"])) {
			return ["status" => "invalid-amount"];
		}elseif(empty($posted["duration"])) {
			return ["status" => "invalid-duration"];
		}elseif (empty($posted["plan"])) {
			return ["status" => "invalid-plan"];
		}elseif (empty($posted["type"])) {
			return ["status" => "invalid-type"];
		}

		try {
			$database = Database::connect();
			$table = self::$table;
			$database->prepare("UPDATE {$table} SET network = :network, amount = :amount, duration = :duration, bundle = :bundle, type = :type, plan = :plan WHERE id = :id LIMIT 1");
			$merged = array_merge($posted, ["id" => $id]);
			$database->execute($merged);
			return ($database->rowCount() > 0) ? ["status" => "success"] : ["status" => "error"];
		} catch (Exception $error) {
			Logger::log("EDITING TARIFF ERROR", $error->getMessage(), __FILE__, __LINE__);
			return ["status" => "error"];
		}
	}

	public static function getTariffsByUserLevel($user) {
		try {
			$allTariffs = self::getAllTariffs();
			if(empty(Users::getById($user))) return ['status' => 0, 'message' => 'User Not Found'];
			$fund = Funds::getFund($user);
            $level = Levels::getDiscountByLevel($fund->level);
			$newTariffs = [];
			foreach ($allTariffs as $tariff) {
				$discount = $tariff->amount * (float)$level->discount;
				$tariff->amount = $tariff->amount - $discount;
				$newTariffs[] = $tariff;
			}
			return ['discount' => $level->discount, 'level' => $fund->level, 'tariffs' => $newTariffs];
		} catch (Exception $error) {
			Logger::log("GETTING ALL TARIFFS BY USER LEVEL ERROR", $error->getMessage(), __FILE__, __LINE__);
			return false;
		}
	}

}

// 07054064568,08039209380,08037581792,07035181845,08037430942,08030817776,08035090548,08037418188,08035010116,08037583193,08032743875,08037241455,08032081855,+16027511261,08063285886,08033078671,09092565355,08130052359,08039329644,08064410235,+16149061262,08033377872,08066241958,08058425936,08039415115,08032606658,08033338949,08038725218,08033433867,08034820040,08037795719,08036741302,08068577289,08033465913,08064834056,08033532953,08033323262,08033820823,08062646419,08033129574,08059062140,08063517637,08036770783,08067072223,08033219392,08034937767,08034937717,08035507271,08037254371,08033419878,08037062115,08125311879,08037578785,08033417803,08066241958,08023135202,38607841,+12049305525,08068964166,08033888702,08033425958,08034901139,08174742758,08036743810,+12404415303,08033404344,08095478882,08055032511,08063995584,08034732782,07038148295,08033119902,+12104011165,08063562710,08068837092,08033422091,08033561960,07055603698,08064334446,08064811295,08026744485,08033497985,08037464581,08033316329,08036088573,08033229995,08033404218,08036378803,08077448329,+447847532762,+15210459199,08036697973,08037102990,08033047249,08033391851,08036684758,07037600514,07052833418,08142218577