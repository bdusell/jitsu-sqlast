<?php

namespace Jitsu\Sql\Ast;

/* A SELECT statement as an expression, with an optional AS clause.
 *
 * <select-expression> ->
 *   "(" <select-statement> ")" ["AS" <identifier>]
 */
class SelectExpression extends Expression {

	public $select;
	public $as;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('SelectStatement', 'select');
		$this->validateClass('Identifier', 'as');
	}
}
