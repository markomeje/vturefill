<?php 

namespace VTURefill\Controllers;
use VTURefill\Models\{Subscriptions};
use VTURefill\Core\{Controller, View, Json};



class SubscriptionsController extends Controller {

	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = ['backendLinks' => $this->backendLinks, 'activeController' => $this->activeController, 'allTvSubscriptions' => Subscriptions::getAllTvSubscriptions(), 'tvs' => Subscriptions::$tvs];
		View::render('backend', 'subscriptions/index', $data);
	}

	public function addTvSubscription() {
		if ($this->request->method('ajax')) {
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$duration = isset($this->request->post()['duration']) ? $this->request->post()['duration'] : '';
			$tv = isset($this->request->post()['tv']) ? $this->request->post()['tv'] : '';
			$posted = ['amount' => $amount, 'duration' => $duration, 'plan' => $plan, 'tv' => $tv];
			$response = Subscriptions::addTvSubscription($posted);
		    Json::encode($response);
		}
	}

	public function editTvSubscription($id) {
		if ($this->request->method('ajax')) {
			$plan = isset($this->request->post()['plan']) ? $this->request->post()['plan'] : '';
			$amount = isset($this->request->post()['amount']) ? $this->request->post()['amount'] : '';
			$duration = isset($this->request->post()['duration']) ? $this->request->post()['duration'] : '';
			$tv = isset($this->request->post()['tv']) ? $this->request->post()['tv'] : '';
			$posted = ['amount' => $amount, 'duration' => $duration, 'plan' => $plan, 'tv' => $tv];
			$response = Subscriptions::editTvSubscription($posted, $id);
		    Json::encode($response);
		}
	}

	public function getAllTvSubscriptions() {
		if ($this->request->method('get')) {
			$response = Subscriptions::getAllTvSubscriptions();
			Json::encode($response);
		}
	}

	public function getSubscriptionByTv() {
		if ($this->request->method('get')) {
			$tv = isset($this->request->get()['tv']) ? $this->request->get()['tv'] : '';
			$response = Subscriptions::getSubscriptionByTv($tv);
			Json::encode($response);
		}
	}

}