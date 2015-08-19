<?php

namespace Jitsu\Sql\Ast;

/* A VALUES statement, minus the optional ORDER BY and LIMIT clauses.
 *
 * <values-statement> ->
 *   "VALUES" ("(" <expression>+{","} ")")+{","}
 */
class ValuesStatementCore extends SelectStatementCore {

	public $values;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateArrayArray('Expression', 'values');
	}
}
