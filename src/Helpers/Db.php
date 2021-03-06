<?php

namespace Helpers;

class Db {

	private $db;

	public function __construct() {

		$config = new \Doctrine\DBAL\Configuration();

		$pathToConfigFile = __DIR__ . '/../Config/database.php';

		if (file_exists($pathToConfigFile))
	       	$connectionParams = include $pathToConfigFile;
	  	else
	  		throw new \Exception("Database file configuration not found", 500);
	  	
		$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

		$this->db = $conn;

	}

	/**
	 * deprecated
	 */
	private function sqlSelectString($table, $where, $fields = null, $order = null) {

		if ($fields != null)
			$string = 'SELECT ' . implode(', ', $fields) . ' ';
		else
			$string = 'SELECT * ';

		$string .= 'FROM ' . $table . ' WHERE ';

		$firstCondition = array_keys($where)[0];

		foreach ($where as $field => $value) {

			$hasComma = $field != $firstCondition? ', ' : '';

			$string .= $hasComma . $field . ' = ?';
			
		}

		if ($order != null && !empty($order)) {

			$string .= 'ORDER BY ' . implode(', ', $order);

		}

		return $string;

	}

	public function fetchAssoc($sql, $fieldsValues) {

		return $this->db->fetchAssoc($sql, $fieldsValues);

	}

	public function fetchAll($sql, $fieldsValues) {

		return $this->db->fetchAll($sql, $fieldsValues);

	}

	public function date() {

		return $this->db->fetchAssoc('SELECT CURDATE()')['CURDATE()'];

	}


	public function now() {

		return $this->db->fetchAssoc('SELECT NOW()')['NOW()'];

	}

	public function insert($table, $params) {

		return $this->db->insert($table, $params);

	}

}