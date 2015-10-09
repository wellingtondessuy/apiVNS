<?php

class Db {

	private $db;

	public function __construct() {
		try {
			$this->db = mysql_connect('192.168.25.7:3306', 'root');
		} catch (Exception $e) {
			
			die(var_dump($e));
		}

		


	}

	public function query() {

	}

	public function fetchOne() {
		
	}

}