<?php

namespace Jitsu\Sql\Ast;

/* SQL integer type. */
class IntegerType extends Type {

	public $bytes;
	public $signed;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('bytes');
		$this->validateBool('signed');
	}

	public function unsigned() {
		$this->signed = false;
		return $this;
	}

	public function signed() {
		$this->signed = true;
		return $this;
	}
}
