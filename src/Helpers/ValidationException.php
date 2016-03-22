<?php

namespace Helpers;

class ValidationException extends \Exception {

	public function __construct($message,$code) {

		$this->message = $message;

		$this->code = $code;

	}

}