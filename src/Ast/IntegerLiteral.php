<?php

namespace Jitsu\Sql\Ast;

/* An integer constant.
 *
 * <integer-literal> ->
 *   [some integer]
 */
class IntegerLiteral extends LiteralExpression {

	public $value;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateInt('value');
	}
}
