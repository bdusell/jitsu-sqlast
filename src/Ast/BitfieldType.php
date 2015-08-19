<?php

namespace Jitsu\Sql\Ast;

/* SQL bitfield type. */
class BitfieldType extends Type {

	public $width;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('width');
	}
}
