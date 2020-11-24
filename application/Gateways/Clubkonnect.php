<?php

namespace VTURefill\Gateways;
use VTURefill\Core\Logger;
use \Exception;
use \GuzzleHttp\Client;
use VTURefill\Library\Curl;


class Clubkonnect {


    public function __construct() {}


	public static function buyDataBundle($data) {
        try{
        	$info = ["UserID" => CLUBKONNECT_USER_ID, "APIKey" => CLUBKONNECT_API_KEY, "MobileNetwork" => $data["network"], "DataPlan" => $data["plan"], "MobileNumber" => $data["phone"], "RequestID" => 3412, "CallBackURL" => DOMAIN."/orderData"];
            $query = "?".http_build_query($info);
            $response = Curl::get(CLUBKONNECT_DATA_BUNDLE_API_URL.$query);
            return $response;
        } catch(Exception $error) {
            Logger::log("CLUBKONNECT BUY DATA BUNDLE API ERROR", $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

    public static function apiResponses(string $status) {
        switch ($status) {
            case 'ORDER_RECEIVED':
                return ["code" => 1, "message" => "Order has been received and is awaiting processing"];
                break;

            case 'ORDER_COMPLETED':
                return ["code" => 2, "message" => "Transaction was sent and response received from mobile network operator that the transaction was successful"];
                break;

            case 'ORDER_CANCELLED':
                return ["code" => -1, "message" => "Transaction was sent and response received from mobile network operator that the transaction was unsuccessful and as such was cancelled by our system"];
                break;

            case 'ORDER_ONHOLD':
                return ["code" => -2, "message" => "Transaction was sent and response received from mobile network operator that the transaction was unsuccessful but was placed on hold by our system"];
                break;

            case 'INSUFFICIENT_APIBALANCE':
                return ["code" => -3, "message" => "Insufficient api balance"];
                break;
            
            default:
                return ["code" => 0, "message" => "Api error"];
                break;
        }
    }

}