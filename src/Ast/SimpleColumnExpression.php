<?php

namespace Jitsu\Sql\Ast;

/* An expression with an optional AS clause.
 *
 * <simple-column-expression> ->
 *   <expression> ["AS" <identifier>]
 */
class SimpleColumnExpression extends ColumnExpression {

	public $expr;
	public $as;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateOptionalClass('Identifier', 'as');
	}
}
