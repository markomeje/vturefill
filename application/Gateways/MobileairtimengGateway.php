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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/datashare?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/datatopup.php?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/power-lists?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/customercheck?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/power-validate?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/power-pay?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/multichoice?'.$query);
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
            $response = Curl::get(MOBILE_AIRTIME_NG_API_BASE_URL.'/startimes?'.$query);
            return Json::decode($response);
        } catch(Exception $error) {
            Logger::log('SUBSCRIBING FOR STARTIMES API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

}