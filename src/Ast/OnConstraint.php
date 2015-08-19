<?php

namespace Jitsu\Sql\Ast;

/* An ON constraint for a JOIN expression.
 *
 * <on-constraint> ->
 *   "ON" <expression>
 */
class OnConstraint extends JoinConstraint {

	public $expr;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
	}
}
