<?php

namespace Jitsu\Sql\Ast;

/* A column assignment in a SET clause.
 *
 * <assignment> ->
 *   <identifier> "=" <expression>
 */
class Assignment extends Node {

	public $column;
	public $expr;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Identifier', 'column');
		$this->validateClass('Expression', 'expr');
	}
}
