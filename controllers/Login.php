<?php

require_once('../helpers/Db.php');

class Login {

	private $app;

	private $request;

	private $response;

	public function __construct(&$app) {
		$this->request = $app->request;
		$this->response = $app->response;
	}

	public function insert() {

		$data = json_decode($this->request->getBody(), true);

		if ($data['username'] == 'login_admin' && $data['password'] == 'senha_admin') {
			$this->response->setStatus(200);	
			$this->response->write(json_encode(array('client_id' => 1)));
		} else {
			$this->response->setStatus(401);
		}

	}
	
}

?>