<?php

class Transaction extends Base {

	public function __construct(&$app) {
		parent::setUp($app);
	}

	private function validateInsert($data) {

		if (!isset($data['value']) || !is_numeric($data['value']) || !is_int($data['value']))
			throw new Exception("Invalid value for transaction.", 400);
		
		if (!isset($data['description']) || !is_string($data['description']))
			throw new Exception("Invalid description for transaction.", 400);

	}

	public function insert() {

		// Pegar o id do header do request
		$clientId = 1;

		if (!$clientId)
			throw new Exception("Invalid client id.", 400);

		$data = json_decode($this->app->request->getBody(), true);

		$this->validateInsert($data);

		$result = $this->getDI('db')->insert('transactions',
			array(
				'value' 			=> $data['value'],
				'user_id' 			=> $clientId,
				'executed_at' 		=> isset($data['executed_at'])? $data['executed_at'] : null,
				'expiration_date' 	=> isset($data['expiration_date'])? $data['expiration_date'] : null,
				'description' 		=> $data['description']
			)
		);

		if ($result) 
			$this->app->response->setStatus(201);
		else
			$this->app->response->setStatus(500);

	}

	public function findById($id) {

		// Pegar o id do header do request
		$clientId = 1;

		if (!$clientId)
			throw new Exception("Invalid client id.", 400);

		$result = $this->getDI('db')->fetchAssoc('transactions', array('id' => $id));

		if ($result) {
			$this->app->response->setStatus(200);
			$this->app->response->write($result);
		} else 
			$this->app->response->setStatus(404);
	}
	
}

?>