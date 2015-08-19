<?php

namespace Jitsu\Sql\Ast;

/* A literal string.
 *
 * <string-literal> ->
 *   '[some string of characters]'
 */
class StringLiteral extends LiteralExpression {

	public $value;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateString('value');
	}
}
