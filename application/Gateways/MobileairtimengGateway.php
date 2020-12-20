<?php

namespace VTURefill\Gateways;
use VTURefill\Core\Logger;
use \Exception;
use VTURefill\Library\Curl;
use VTURefill\Core\Json;


class MobileairtimengGateway {


    public function __construct() {}


	public static function topUpAirtime($data) {
        try{
        	$info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'network' => $data['network'], 'phone' => $data['phone'], 'amt' => $data['amount'], 'user_ref' => $data['reference'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_AIRTIME_TOPUP_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('TOP UP AIRTIME API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function mtnSmeData($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'network' => $data['network'], 'phone' => $data['phone'], 'datasize' => $data['datasize'], 'user_ref' => $data['reference'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_MTN_SME_DATA_API_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('MTN SME DATA API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }
    
    public static function directTopUp($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'network' => $data['network'], 'phone' => $data['phone'], 'user_ref' => $data['reference'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_DATA_TOP_UP_API_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('DATA TOP UP API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function powerLists() {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_POWER_LISTS_API_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('DATA TOP UP API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

}