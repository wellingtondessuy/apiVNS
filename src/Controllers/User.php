<?php

namespace Controllers;

use Controllers\Base;
use Helpers\ValidationException as ValidationException;

class User extends Base {

	public function __construct(&$app) {
		parent::setUp($app);
	}

	public function insert() {

		$data = $this->getRequestData();

		if (!isset($data['login']) || !isset($data['password']) || !isset($data['email'])) {
			throw new \Exception('Parâmetros inválidos na inserção do usuário', 400);
		}

		$db = $this->getDI('db');

		$result = $db->fetchAssoc('SELECT id, login, password FROM users WHERE login = ? OR email = ?', array($data['login'], $data['email']));

		if ($result) {
			
			throw new \Exception('Usuário/Email já existe', 406);
			
		} else {

			$auth = $this->getDI('auth');

			$encryptedPassword = $auth->encryptPassword($data['login'], $data['email'], $data['password']);

			$db->insert('users', array(
				'login' => $data['login'],
				'password' => $encryptedPassword,
				'email' => $data['email']
				));

			$this->app->response->setStatus(201);

		}

	}
	
}

?>