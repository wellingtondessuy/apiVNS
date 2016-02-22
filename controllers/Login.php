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

		$db = $this->getDI('db');

		$result = $db->fetchAssoc('SELECT id, login, password FROM usuarios WHERE login = ?', array($data['username']));

		if ($result) {
			
			if ($data['password'] == $result['password']) {
				$this->app->response->setStatus(200);	
				$this->app->response->write(json_encode(array('client_id' => 1)));
			} else {
				$this->app->response->setStatus(401);
			}
			
		} else {

			$this->app->response->setStatus(404);

		}

	}
	
}

?>