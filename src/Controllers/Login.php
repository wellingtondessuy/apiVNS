<?php

namespace Controllers;

use Controllers\Base;

class Login extends Base {

	public function __construct(&$app) {

		parent::setUp($app);
	
	}

	public function insert() {
		
		$data = $this->getRequestData();

		if (!isset($data['login']) || !isset($data['password'])) {
			
			throw new \Exception('Parâmetros inválidos no login', 400);
			
		}

		$db = $this->getDI('db');

		$result = $db->fetchAssoc('SELECT id, login, password, email FROM users WHERE login = ?', array($data['login']));

		if ($result) {
			
			$auth = $this->getDI('auth');

			$encryptedPassword = $auth->encryptPassword($result['login'], $result['email'], $data['password']);

			if ($encryptedPassword == $result['password']) {

				$token = $auth->generateToken($result['login'], $encryptedPassword);

				$this->app->response->write(json_encode(array('token' => $token)));
				
				$this->app->response->setStatus(200);
			
			} else {

				throw new \Exception('Dados inválidos', 401);

			}
			
		} else {

			throw new \Exception('Usuário não encontrado', 404);

		}

	}
	
}

?>