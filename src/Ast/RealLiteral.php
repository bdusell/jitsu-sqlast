<?php

namespace Jitsu\Sql\Ast;

/* A real number constant.
 *
 * <real-literal> ->
 *   [some real number]
 */
class RealLiteral extends LiteralExpression {

	public $value;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateFloat('value');
	}
}
