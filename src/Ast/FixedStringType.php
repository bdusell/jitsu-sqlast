<?php

namespace Jitsu\Sql\Ast;

/* SQL fixed string type. */
class FixedStringType extends CharacterStringType {

	public $length;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('length');
	}
}
