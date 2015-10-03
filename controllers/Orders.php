<?php

class Orders {

	private $request;
	private $response;

	public function __construct(&$request, &$response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function insert() {
		echo $this->request->getMethod();
		echo '   ';
		echo 'insert';
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