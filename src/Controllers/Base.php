<?php

namespace Controllers;

class Base {

	public $app;

	public function setUp($app) {

		$this->app = $app;
		
	}

	public function getRequestData() {

		$data = json_decode($this->app->request->getBody(), true);

		return $data;

	}

	public function getDI($dependence) {

		return $this->app->$dependence;

	}

	public function setDI($name, $dependence) {

		$this->app->container->singleton($name, function() use ($dependence){ return $dependence; });	

	}
	
}

?>