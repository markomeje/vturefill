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
            Logger::log('REFILL BUY DATA BUNDLE API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function cancelTransaction($orderId) {
        try{
            $info = ['userid' => REFILL_USER_ID, 'pass' => REFILL_PASSWORD, 'OrderID' => $orderId];
            $query = '?'.http_build_query($info);
            $response = Curl::get(REFILL_CANCEL_TRANSACTION_URL.$query);
            return $response;
        } catch(Exception $error) {
            Logger::log('REFILL CANCEL TRANSACTION API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function queryTransaction($url) {
        try{
            $response = Curl::get($url);
            return $response;
        } catch(Exception $error) {
            Logger::log('REFILL CANCEL TRANSACTION API ERROR', $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function apiResponses(string $status) {
        switch ($status) {
            case 'ORDER_RECEIVED':
                return ['code' => 1, 'message' => 'Order has been received and is awaiting processing'];
                break;

            case 'ORDER_COMPLETED':
                return ['code' => 2, 'message' => 'Transaction was sent and response received from mobile network operator that the transaction was successful'];
                break;

            case 'ORDER_CANCELLED':
                return ['code' => -1, 'message' => 'Transaction was sent and response received from mobile network operator that the transaction was unsuccessful and as such was cancelled by our system'];
                break;

            case 'ORDER_ONHOLD':
                return ['code' => -2, 'message' => 'Transaction was sent and response received from mobile network operator that the transaction was unsuccessful but was placed on hold by our system'];
                break;

            case 'INSUFFICIENT_APIBALANCE':
                return ['code' => -3, 'message' => 'Insufficient api balance'];
                break;
            
            default:
                return ['code' => 0, 'message' => 'Api error'];
                break;
        }
    }

}