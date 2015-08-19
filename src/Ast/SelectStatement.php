<?php

namespace Jitsu\Sql\Ast;

/* A complete, executable SELECT or VALUES statement.
 *
 * <select-statement> ->
 *   <select-statement-core>
 *   ["ORDER" "BY" <ordered-expression>+{","}]
 *   ["LIMIT" <expression> ["OFFSET" <expression>]]
 */
class SelectStatement extends LimitedStatement {

	public $core;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('SelectStatementCore', 'core');
	}
}
