<?php

namespace Jitsu\Sql\Ast;

/* SQL binary blob type. */
class BlobType extends Type {

	public $prefix_size;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('prefix_size');
	}
}
