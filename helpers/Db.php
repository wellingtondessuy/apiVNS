<?php

class Db {

	private $db;

	private function instance() {
		try {
			$this->db = mysql_connect('localhost', 'root', 'rootpass');

			$result = mysql_select_db('apivns', $this->db);
			
			if (!$result)
				die(var_dump('Erro ao selecionar o banco de dados.'));

		} catch (Exception $e) {
			die(var_dump($e));
		}
	}

	public static function query() {
		
	}

	public static function fetchOne() {
		die('entrou no fetchOne');
	}

}