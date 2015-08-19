<?php

namespace Jitsu\Sql\Ast;

/* A scalar or aggregate function call.
 *
 * <function-call> ->
 *   [function name] "(" ["*" | ["DISTINCT"] <expression>+{","}] ")"
 */
class FunctionCall extends AtomicExpression {

	public $name;
	public $distinct;
	public $arguments;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateString('name');
		$this->validateBool('distinct');
		$this->validateEmptyableArray('Expression', 'arguments');
	}
}
