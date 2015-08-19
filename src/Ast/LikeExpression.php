<?php

namespace Jitsu\Sql\Ast;

/* `LIKE` operator with optional `ESCAPE` clause.
 *
 * <like-expression> ->
 *   <expression> "LIKE" <expression> ["ESCAPE" <expression>]
 */
class LikeExpression extends Expression {

	public $expr;
	public $pattern;
	public $escape;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'expr');
		$this->validateClass('Expression', 'pattern');
		$this->validateOptionalClass('Expression', 'escape');
	}
}
