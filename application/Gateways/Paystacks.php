<?php

namespace VTURefill\Gateways;
use VTURefill\Core\Logger;
use Yabacon\Paystack;
use Yabacon\Paystack\Exception\ApiException;


class Paystacks {

	public $paystack;

	public function __construct() {
		$this->paystack = new Paystack(PAYSTACK_TEST_SECRET_KEY);
	}

	public function initialize($data = []) {
        try{
            return $this->paystack->transaction->initialize($data);
        } catch(ApiException $error){
        	Logger::log("PAYSTACK API INITIALIZATION ERROR", $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
	    }
    }

    public function verify($reference) {
        try{
            return $this->paystack->transaction->verify(["reference" => $reference]);
        } catch(ApiException $error){
        	Logger::log("PAYSTACK API VERIFICASTION ERROR", $error->getMessage(), $error->getFile(), $error->getLine());
            return false;
	    }
    }

    public function event() {
    	// Retrieve the request's body and parse it as JSON
	    $event = Yabacon\Paystack\Event::capture();
	    http_response_code(200);

	    /* It is a important to log all events received. Add code *
	     * here to log the signature and body to db or file       */
	    openlog('MyPaystackEvents', LOG_CONS | LOG_NDELAY | LOG_PID, LOG_USER | LOG_PERROR);
	    syslog(LOG_INFO, $event->raw);
	    closelog();

	    /* Verify that the signature matches one of your keys*/
	    $my_keys = ['live' => 'sk_live_blah', 'test' => 'sk_test_blah'];
	    $owner = $event->discoverOwner($my_keys);
	    if(!$owner){
	        // None of the keys matched the event's signature
	        die();
	    }

	    // Do something with $event->obj
	    // Give value to your customer but don't give any output
	    // Remember that this is a call from Paystack's servers and
	    // Your customer is not seeing the response here at all
	    switch($event->obj->event){
	        // charge.success
	        case 'charge.success':
	            if('success' === $event->obj->data->status){
	                // TIP: you may still verify the transaction
	                // via an API call before giving value.
	            }
	            break;
	    }
    }


}