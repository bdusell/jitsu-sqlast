<?php

namespace Jitsu\Sql\Ast;

/* SQL variable-length binary string type. */
class ByteStringType extends Type {

	public $maximum_length;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('maximum_length');
	}
}
