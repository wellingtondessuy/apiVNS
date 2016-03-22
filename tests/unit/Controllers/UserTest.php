<?php

namespace Unit\Controllers;

use Unit\BaseTest;
use Controllers\User;

class UserTest extends BaseTest {

	public function setUp() {

		parent::setUpController();

		$this->instance = new User($this->app);

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Parâmetros inválidos na inserção do usuário
	 * @expectedExceptionCode 400
	 */
	public function testInsertWithoutParams() {

		$this->setRequestData(array());

		$this->instance->insert();

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Parâmetros inválidos na inserção do usuário
	 * @expectedExceptionCode 400
	 */
	public function testInsertWithOnlyUsername() {

		$this->setRequestData(array('login' => 'test_user'));

		$this->instance->insert();

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Parâmetros inválidos na inserção do usuário
	 * @expectedExceptionCode 400
	 */
	public function testInsertWithoutPassword() {

		$this->setRequestData(array(
			'login' => 'test_user', 
			'email' => 'test@email.com'
		));

		$this->instance->insert();

	}

	public function testInsertUser() {

		$this->setRequestData(array(
			'login' => 'test_user', 
			'email' => 'test@email.com', 
			'password' => 'password'
		));

		$mockAuth = $this->getClassMock('\Helpers\Auth', array('encryptPassword'));;

		$mockAuth->expects($this->once())
			->method('encryptPassword')
			->with('test_user', 'test@email.com', 'password')
			->willReturn('encryptedPassword');
		
		$this->instance->setDI('auth', $mockAuth);

		$mockDb = $this->getClassMock('\Helpers\Db', array('fetchAssoc', 'insert'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->with('SELECT id, login, password FROM users WHERE login = ? OR email = ?',
					array('test_user', 'test@email.com'))
			->willReturn(array());

		$mockDb->expects($this->once())
			->method('insert')
			->with('users', array(
				'login' => 'test_user',
				'password' => 'encryptedPassword',
				'email' => 'test@email.com'
				));
		
		$this->instance->setDI('db', $mockDb);

		$this->instance->insert();

		$this->assertEquals(201, $this->instance->app->response->getStatus());

	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Usuário/Email já existe
	 * @expectedExceptionCode 406
	 */
	public function testInsertLoginOrEmailAlreadyExists() {

		$this->setRequestData(array(
			'login' => 'test_user', 
			'email' => 'test@email.com', 
			'password' => 'password'
		));

		$mockDb = $this->getClassMock('\Helpers\Db', array('fetchAssoc'));

		$mockDb->expects($this->once())
			->method('fetchAssoc')
			->willReturn(array('id' => 123, 'login' => 'test_user', 'password' => 'wrong_password'));
		
		$this->instance->setDI('db', $mockDb);

		$this->instance->insert();

	}

}