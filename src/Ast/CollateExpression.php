<?php

namespace Jitsu\Sql\Ast;

/* An expression with a COLLATE clause.
 *
 * <collate-expression> ->
 *   <expression> "COLLATE" [collation name]
 */
class CollateExpression extends Expression {

	public $collation;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateConst('collation');
	}
}
