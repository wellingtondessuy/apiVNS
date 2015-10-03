<?php 

class Orders {

	public function insert() {
		echo 'insert';
	}

	public function findById($id) {
		echo 'findById' . $id;
	}

	public function findAll() {
		echo 'findAll';
	}

	public function update($id) {
		echo 'update' . $id;
	}

	public function delete($id) {
		echo 'delete' . $id;
	}

}

?>