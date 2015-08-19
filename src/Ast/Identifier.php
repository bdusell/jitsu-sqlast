<?php

namespace Jitsu\Sql\Ast;

/* An identifier, such as a column or table name. */
class Identifier extends Node {

	public $value;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateString('value');
	}
}
