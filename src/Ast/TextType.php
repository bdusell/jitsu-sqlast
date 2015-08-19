<?php

namespace Jitsu\Sql\Ast;

/* SQL text type. */
class TextType extends CharacterStringType {

	public $prefix_size;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('prefix_size');
	}
}
