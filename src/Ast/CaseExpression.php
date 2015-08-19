<?php

namespace Jitsu\Sql\Ast;

/* A CASE-WHEN-THEN-ELSE-END expression.
 *
 * <case-expression> ->
 *   "CASE" [<expression>] <when-clause>+ ["ELSE" <expression>] "END"
 */
class CaseExpression extends Expression {

	public $expr;
	public $cases;
	public $else;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateOptionalClass('Expression', 'expr');
		$this->validateArray('WhenClause', 'cases');
		$this->validateOptionalClass('Expression', 'else');
	}
}
