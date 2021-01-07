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
            $response = Curl::get(MOBILE_AIRTIME_NG_AIRTIME_TOPUP_API_URL.$query);
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
            Logger::log('GETTING POWER LISTS API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function validateTvMeterNumber($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'bill' => $data['bill'], 'smartno' => $data['smartno'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_VALIDATE_TV_METER_NUMBER_API_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('VALIDATING TV METER NUMBER API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function validateElectricityMeterNumber($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'service' => $data['service'], 'meterno' => $data['meterno'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_VALIDATE_ELECTRICITY_METER_NUMBER_API_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('VALIDATING ELECTRICITY METER NUMBER API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function buyElectricity($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'service' => $data['service'], 'meterno' => $data['meterno'], 'mtype' => $data['mtype'], 'amt' => $data['amount'], 'user_ref' => $data['reference'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_BUY_ELECTRICITY_API_URL.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('BUYING ELECTRICITY API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function subscribeGotvDstv($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'phone' => $data['phone'], 'smartno' => $data['smartno'], 'customer' => $data['customer'], 'amt' => $data['amount'], 'invoice' => $data['invoice'], 'billtype' => $data['billtype'], 'customernumber' => $data['customernumber'], 'user_ref' => $data['reference'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_GOTV_DSTV_RECHARGE_API.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('SUBSCRIBING FOR '. strtoupper($data['billtype']) .' API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function subscribeStartimes($data) {
        try{
            $info = ['userid' => MOBILE_AIRTIME_NG_USER_ID, 'pass' => MOBILE_AIRTIME_NG_API_KEY, 'phone' => $data['phone'], 'smartno' => $data['smartno'], 'amt' => $data['amount'], 'user_ref' => $data['reference'], 'jsn' => 'json'];
            $query = http_build_query($info);
            $response = Curl::get(MOBILE_AIRTIME_NG_STARTIMES_RECHARGE_API.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('SUBSCRIBING FOR STARTIMES API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

}