<?php

class Db {

	private $db;

	public function __construct() {

		$config = new \Doctrine\DBAL\Configuration();

		$pathToConfigFile = '../config/database.php';

		if (file_exists($pathToConfigFile))
	       	$connectionParams = include $pathToConfigFile;
	  	else
	  		throw new Exception("Database file configuration not found", 500);
	  	
		$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

		$this->db = $conn;

	}

	public function fetchAssoc($sql, $params) {

		return $this->db->fetchAssoc($sql, $params);

	}

	public function fetchAll($sql, $params) {

		return $this->db->fetchAll($sql, $params);

	}

}