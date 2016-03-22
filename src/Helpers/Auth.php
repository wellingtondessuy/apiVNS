<?php

namespace Helpers;

use \Helpers\Db;

class Auth {

	public function encryptPassword($username, $email, $password) {

		$hash = $username . $email . $password;

		for ($i = 0; $i < 50; $i++) {

			$hash = md5($hash);

		}

		return $hash;

	}

	public function generateToken($login, $password) {

		$login = base64_encode($login);
		$password = base64_encode($password);

		$token = $login . '=;=' . $password;

		for ($i = 0; $i < 2; $i++) {

			$token = base64_encode($token);

		}

		return $token;

	}

	public function decodeToken($token) {

		for ($i = 0; $i < 2; $i++) {

			$token = base64_decode($token);

		}

		preg_match_all("/(.*)=;=(.*)/", $token, $output);

		$login = base64_decode($output[1][0]);
		$password = base64_decode($output[2][0]);

		return array('login' => $login, 'password' => $password);

	}

	public function getDb() {

		return new \Helpers\Db();

	}

	public function verifyAuthentication($token) {

		if (empty($token))
			throw new \Exception('Token inválido', 400);

		$data = $this->decodeToken($token);

		$db = $this->getDb();

		$user = $db->fetchAssoc('SELECT id, login, password FROM users WHERE login = ?', array($data['login']));

		if (!$user)
			throw new \Exception('Token inválido', 404);

		if ($user['password'] != $data['password'])
			throw new \Exception('Token inválido', 401);

	}

}