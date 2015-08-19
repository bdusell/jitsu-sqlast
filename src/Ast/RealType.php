<?php

namespace Jitsu\Sql\Ast;

/* SQL real type. */
class RealType extends Type {

	public $bytes;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('bytes');
	}
}
