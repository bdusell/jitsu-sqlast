<?php

namespace Jitsu\Sql\Ast;

/* An expression with an ASC or DESC qualifier.
 *
 * <ordered-expression> ->
 *   <expression> ["ASC" | "DESC"]
 */
class OrderedExpression extends Node {

	const ASC = 'ASC';
	const DESC = 'DESC';

	public $expr;
	public $order;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateConst('order');
	}
}
