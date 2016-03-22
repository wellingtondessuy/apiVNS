<?php

namespace Unit\Controllers;

use Unit\BaseTest;
use Controllers\Login;

class LoginTest extends BaseTest {

	public function setUp() {

		parent::setUpController();

		$this->instance = new Login($this->app);

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Parâmetros inválidos no login
	 * @expectedExceptionCode 400
	 */
	public function testInsertWithoutParams() {

		$this->setRequestData(array());

		$this->instance->insert();

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Parâmetros inválidos no login
	 * @expectedExceptionCode 400
	 */
	public function testInsertWithoutPassword() {

		$this->setRequestData(array('login' => 'login_user'));

		$this->instance->insert();

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Usuário não encontrado
	 * @expectedExceptionCode 404
	 */
	public function testInsertUserNoExists() {

		$this->setRequestData(array('login' => 'login_user', 'password' => 'pass_user'));

		$mockDb = $this->getClassMock('Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->with('SELECT id, login, password, email FROM users WHERE login = ?', 
					array('login_user'))
			->willReturn(array());

		$this->instance->setDI('db', $mockDb);

		$this->instance->insert();

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Dados inválidos
	 * @expectedExceptionCode 401
	 */
	public function testInsertWrongPassword() {

		$this->setRequestData(array('login' => 'login_user', 'password' => 'pass_user'));

		$mockDb = $this->getClassMock('Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->willReturn(array('login' => 'login_user', 'email' => 'email@user.com', 'password' => 'encryptedPassword'));

		$this->instance->setDI('db', $mockDb);

		$mockAuth = $this->getClassMock('Helpers\Auth', array('encryptPassword'));

		$mockAuth->expects($this->once())
			->method('encryptPassword')
			->with('login_user', 'email@user.com', 'pass_user')
			->willReturn('wrongEncryptedPassword');

		$this->instance->setDI('auth', $mockAuth);

		$this->instance->insert();

	}

	public function testInsert() {

		$this->setRequestData(array('login' => 'login_user', 'password' => 'pass_user'));

		$mockDb = $this->getClassMock('Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->willReturn(array('login' => 'login_user', 'email' => 'email@user.com', 'password' => 'encryptedPassword'));

		$this->instance->setDI('db', $mockDb);

		$mockAuth = $this->getClassMock('Helpers\Auth', array('encryptPassword', 'generateToken'));

		$mockAuth->expects($this->once())
			->method('encryptPassword')
			->willReturn('encryptedPassword');

		$mockAuth->expects($this->once())
			->method('generateToken')
			->with('login_user', 'encryptedPassword')
			->willReturn('generated_token');

		$this->instance->setDI('auth', $mockAuth);

		$this->instance->insert();

		$this->assertEquals(200, $this->instance->app->response->getStatus());
		
		$this->assertEquals('{"token":"generated_token"}', $this->instance->app->response->getBody());

	}

}