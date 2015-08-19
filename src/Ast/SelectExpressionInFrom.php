<?php

namespace Jitsu\Sql\Ast;

/* A SELECT expression appearing in a FROM clause.
 *
 * <select-expression-in-from> ->
 *   <select-expression>
 */
class SelectExpressionInFrom extends FromExpression {

	public $select;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('SelectExpression', 'select');
	}
}
