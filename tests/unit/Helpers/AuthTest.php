<?php

namespace Unit\Helpers;

use Unit\BaseTest;
use Helpers\Auth;

class AuthTest extends BaseTest {

	public function setUp() {

		$this->instance = new Auth();

	}

	public function testEncryptPassword() {

		$encryptedPassword = $this->instance->encryptPassword('user_test', 'email@user.com', 'user_pass');

		$this->assertEquals('7b221a8e7d7dfa3e82b6e3ed06dfa339', $encryptedPassword);

	}

	public function testGenerateToken() {

		$token = $this->instance->generateToken('user_test', 'user_pass');

		$this->assertEquals('WkZoT2JHTnNPVEJhV0U0d1BUczlaRmhPYkdOc09YZFpXRTU2', $token);

		return $token;

	}

	/**
	 * @depends testGenerateToken
	 */
	public function testDecodeToken($token) {

		$data = $this->instance->decodeToken($token);

		$this->assertEquals('user_test', $data['login']);
		$this->assertEquals('user_pass', $data['password']);

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Token inválido
	 * @expectedExceptionCode 400
	 */
	public function testVerifyAuthenticationInvalidToken() {

		$this->instance->verifyAuthentication('');

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Token inválido
	 * @expectedExceptionCode 404
	 */
	public function testVerifyAuthenticationUserNotFoundForToken() {

		$this->instance = $this->getClassMock('Helpers\Auth', array('decodeToken', 'getDb'));

		$this->instance->expects($this->once())
			->method('decodeToken')
			->with('token')
			->willReturn(array('login' => 'user_login', 'password' => 'user_pass'));

		$mockDb = $this->getClassMock('Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->with('SELECT id, login, password FROM users WHERE login = ?', array('user_login'))
			->willReturn(array());

		$this->instance->expects($this->once())
			->method('getDb')
			->willReturn($mockDb);

		$this->instance->verifyAuthentication('token');

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Token inválido
	 * @expectedExceptionCode 401
	 */
	public function testVerifyAuthenticationWrongToken() {

		$this->instance = $this->getClassMock('Helpers\Auth', array('decodeToken', 'getDb'));

		$this->instance->expects($this->once())
			->method('decodeToken')
			->with('token')
			->willReturn(array('login' => 'user_login', 'password' => 'wrong_user_pass'));

		$mockDb = $this->getClassMock('Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->with('SELECT id, login, password FROM users WHERE login = ?', array('user_login'))
			->willReturn(array('id' => 1, 'login' => 'user_login', 'password' => 'user_pass'));

		$this->instance->expects($this->once())
			->method('getDb')
			->willReturn($mockDb);

		$this->instance->verifyAuthentication('token');

	}

	public function testVerifyAuthentication() {

		$this->instance = $this->getClassMock('Helpers\Auth', array('decodeToken', 'getDb'));

		$this->instance->expects($this->once())
			->method('decodeToken')
			->with('token')
			->willReturn(array('login' => 'user_login', 'password' => 'user_pass'));

		$mockDb = $this->getClassMock('Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->with('SELECT id, login, password FROM users WHERE login = ?', array('user_login'))
			->willReturn(array('id' => 1, 'login' => 'user_login', 'password' => 'user_pass'));

		$this->instance->expects($this->once())
			->method('getDb')
			->willReturn($mockDb);

		$this->instance->verifyAuthentication('token');

		$this->assertTrue(true);

	}

}