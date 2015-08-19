<?php

namespace Jitsu\Sql\Ast;

/* SQL variable-length string type. */
class StringType extends CharacterStringType {

	public $maximum_length;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('maximum_length');
	}
}
