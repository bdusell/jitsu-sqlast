<?php

namespace Jitsu\Sql\Ast;

/* SQL decimal type. */
class DecimalType extends Type {

	public $digits;
	public $decimals;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('digits');
		$this->validateInt('decimals');
	}
}
