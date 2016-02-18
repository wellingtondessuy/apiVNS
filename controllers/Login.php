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

		$username = $this->request->post('username');
		$password = $this->request->post('password');

		if ($username == 'login_admin' && $password == 'senha_admin') {
			$this->response->setStatus(200);	
			$this->response->write(json_encode(array('client_id' => 1)));
		} else {
			$this->response->setStatus(401);
		}


	}
	
}

?>