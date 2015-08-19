<?php

namespace Jitsu\Sql\Ast;

/* A simple expression consisting of a binary operator and two sub-
 * expressions.
 *
 * <binary-operator-expression> ->
 *   <concatenation-expression> |
 *   <multiplication-expression> |
 *   <division-expression> |
 *   <modulus-expression> |
 *   <addition-expression> |
 *   <subtraction-expression> |
 *   <less-than-expression> |
 *   <less-than-or-equal-expression> |
 *   <greater-than-expression> |
 *   <greater-than-or-equal-expression> |
 *   <equality-expression> |
 *   <inequality-expression> |
 *   <is-expression> |
 *   <and-expression> |
 *   <or-expression>
 */
class BinaryOperatorExpression extends Expression {

	public $left;
	public $right;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'left');
		$this->validateClass('Expression', 'right');
	}
}
