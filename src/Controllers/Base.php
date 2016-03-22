<?php

namespace Controllers;

class Base {

	public $app;

	public function setUp($app) {

		$this->app = $app;
		
	}

	public function getRequestData() {

		return json_decode($this->app->request->getBody(), true);

	}

	public function getDI($dependence) {

		return $this->app->$dependence;

	}

	public function setDI($name, $dependence) {

		$this->app->container->singleton($name, function() use ($dependence){ return $dependence; });	

	}
	
}

?>