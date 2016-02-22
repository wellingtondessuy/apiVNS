<?php

class Base {

	protected $app;

	public function setup($app) {

		$this->app = $app;
		
	}

	public function getDI($dependence) {

		return $this->app->$dependence;

	}
	
}

?>