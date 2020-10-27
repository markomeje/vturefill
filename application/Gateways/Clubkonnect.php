<?php

namespace Application\Gateways;
use Application\Core\Logger;
use GuzzleHttp\Client;
use \Exception;


class Clubkonnect {


	public static function buyDataBundle($data) {
        try{
        	$info = ["UserID" => CLUBKONNECT_USER_ID, "APIKey" => CLUBKONNECT_API_KEY, "MobileNetwork" => $data["network"], "DataPlan" => $data["plan"], "MobileNumber" => $data["phone"], "CallBackURL" => "http://vturefill.build/orders"];
            $query = "?".http_build_query($info);
        	$client = new Client();
        	//echo CLUBKONNECT_DATA_BUNDLE_API_URL.$query;
        	//header("Location: ". CLUBKONNECT_DATA_BUNDLE_API_URL.$query);
			$response = $client->request("GET", CLUBKONNECT_DATA_BUNDLE_API_URL.$query);
			return ["responseBody" => $response->getBody(), "contentType" => $response->getHeaderLine('content-type'), "statusCode" => $response->getStatusCode()];
        } catch(Exception $error){
            Logger::log("CLUBKONNECT DATA BUNDLE API ERROR", $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
        }
    }

}