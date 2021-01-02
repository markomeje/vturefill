<?php 

namespace VTURefill\Models;
use VTURefill\Core\{Model};
use VTURefill\Library\{Validate};
use VTURefill\Models\{User};


class Register extends Model {


	public function __construct() {
		parent::__construct();
	}

	public static function signup($posted) {
		if (empty($posted['username']) || !Validate::range($posted['username'], 8, 15)) {
			return ['status' => 0, 'message' => 'Username must be between 8 - 15 characters'];
		}elseif (empty($posted['email']) || !Validate::email($posted['email']) || !Validate::range($posted['email'], 11, 55)) {
			return ['status' => 0, 'message' => 'Invalid Email. Email must be between 11 - 55 characters'];
		}elseif (Users::emailExists($posted['email']) === true) {
			return ['status' => 0, 'message' => 'Email already exists'];
		}elseif (empty($posted['password'])) {
			return ['status' => 0, 'message' => 'Password is required.'];
		}elseif ($posted['password'] !== $posted['confirmpassword']) {
			return ['status' => 0, 'message' => 'Passwords do not match.'];
		}elseif (empty($posted['phone']) || !Validate::length($posted['phone'], 11)) {
			return ['status' => 0, 'message' => 'Invalid phone number.'];
		}elseif (Users::phoneExists($posted['phone']) === true) {
			return ['status' => 0, 'message' => 'Phone number already exists'];
		}

		try {
			unset($posted['confirmpassword']);
			$posted['password'] = password_hash($posted['password'], PASSWORD_DEFAULT);
			$merged = array_merge($posted, ['status' => 'inactive']);
			$result = Users::register($merged);
			if (isset($result['count']) && $result['count'] > 0) {
				$id = empty($result['id']) ? 0 : $result['id'];
				Funds::addFund(['user' => $id, 'amount' => 0, 'level' => (Levels::getLowestLevel())->minimum]);
				return ['status' => 1, 'message' => 'Registration successfull', 'user' => Users::getById($id)];
			}else {
				return ['status' => 0, 'message' => 'Registration falied. Try again.'];
			}
		} catch (Exception $error) {
			Logger::log('USER REGISTRATION ERROR', $error->getMessage(), __FILE__, __LINE__);
			return ['status' => 0, 'message' => 'Registration falied. Try again.'];
		}
	}

}

