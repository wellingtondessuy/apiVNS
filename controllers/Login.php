<?php

class Login extends Base {

	public function __construct(&$app) {
		parent::setUp($app);
	}

	public function insert() {

		$data = json_decode($this->app->request->getBody(), true);

		if (!isset($data['username']) || !isset($data['password'])) {
			$this->app->response->setStatus(400);
			return;
		}

		if ($data['username'] == 'login_admin' && $data['password'] == 'senha_admin') {
			$this->app->response->setStatus(200);	
			$this->app->response->write(json_encode(array('client_id' => 1)));
		} else {
			$this->app->response->setStatus(401);
		}

	}
	
}

?>