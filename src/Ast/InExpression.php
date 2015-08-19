<?php

namespace Jitsu\Sql\Ast;

/* `IN` operator.
 *
 * <in-expression> ->
 *   <expression> "IN" <in-list>
 */
class InExpression extends Expression {

	public $expr;
	public $in;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateClass('InList', 'in');
	}
}
