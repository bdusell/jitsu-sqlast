<?php

namespace Jitsu\Sql\Ast;

/* An EXISTS expression.
 *
 * <exists-expression> ->
 *   "EXISTS" "(" <select-statement> ")"
 */
class ExistsExpression extends AtomicExpression {

	public $select;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('SelectStatement', 'select');
	}
}
