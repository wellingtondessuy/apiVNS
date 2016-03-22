<?php

namespace Unit;

class BaseTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Variável para guardar a instancia da classe que está sendo testada
	 */
	protected $instance = null;

	protected $app = null;

	public function setUpController() {

		$this->app = new \Slim\Slim();

		$this->app->request = $this->getClassMock('\Slim\Slim\Http\Request', array('getBody'));

	}

	public function tearDown() {

		$this->instance = null;

		$this->app = null;

	}

	protected function getClassMock($path, $methods = array()) {

		return $this->getMockBuilder($path)
			->setMethods($methods)
			->disableOriginalConstructor()
			->getMock();

	}

	protected function setRequestData($data) {

		$this->app->request->expects($this->once())
			->method('getBody')
			->willReturn(json_encode($data));

	}

}