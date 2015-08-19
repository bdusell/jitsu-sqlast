<?php

namespace Jitsu\Sql\Ast;

/* `BETWEEN` operator.
 *
 * <between-expression> ->
 *   <expression> "BETWEEN" <expression> "AND" <expression>
 */
class BetweenExpression extends Expression {

	public $expr;
	public $min;
	public $max;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateClass('Expression', 'min');
		$this->validateClass('Expression', 'max');
	}
}
