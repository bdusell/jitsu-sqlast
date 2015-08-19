<?php

namespace Jitsu\Sql\Ast;

/* A CAST expression to cast an expression to a certain type.
 *
 * <cast-expression> ->
 *   "CAST" "(" <expression> "AS" <type> ")"
 */
class CastExpression extends AtomicExpression {

	public $expr;
	public $type;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateClass('Type', 'type');
	}
}
