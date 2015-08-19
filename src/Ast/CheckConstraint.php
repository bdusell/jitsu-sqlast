<?php

namespace Jitsu\Sql\Ast;

/* A `CHECK` table constraint.
 *
 * <check-constraint> ->
 *   "CHECK" "(" <expr> ")"
 */
class CheckConstraint extends TableConstraint {

	public $expr;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
	}
}
