<?php

require_once('../helpers/Db.php');

class Orders {

	private $db;

	private $app;

	private $request;

	private $response;

	public function __construct(&$app) {
		$this->request = $app->request;
		$this->response = $app->response;
	}

	public function insert() {
		$client_id = $this->request->post('client_id');
		$product_id = $this->request->post('product_id');

		$this->response->setStatus(200);
		$this->response->headers->set('Content-Type', 'application/json');

		$response = array(
			'client_id' => $client_id,
			'product_id' => $product_id,
			);

		$this->response->write(json_encode($response));
	}

	public function findById($id) {
		echo $this->request->getMethod();
		echo '   ';
		echo 'findById' . $id;
	}

	public function findAll() {
		echo $this->request->getMethod();
		echo '   ';
		echo 'findAll';
	}

	public function update($id) {
		echo $this->request->getMethod();
		echo '   ';
		echo 'update' . $id;
	}

	public function delete($id) {
		echo $this->request->getMethod();
		echo '   ';	
		echo 'delete' . $id;
	}

}

?>