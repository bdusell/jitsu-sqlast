<?php

namespace Jitsu\Sql\Ast;

/* A complete UPDATE statement.
 *
 * <update-statement> ->
 *   "UPDATE"
 *   <table-reference>
 *   "SET" <assignment>+{","}
 *   ["WHERE" <expression>]
 *   ["ORDER" "BY" <ordered-expression>+{","}]
 *   ["LIMIT" <expression> ["OFFSET" <expression>]]
 */
class UpdateStatement extends LimitedStatement {

	public $table;
	public $assignments;
	public $where;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('TableReference', 'table');
		$this->validateArray('Assignment', 'assignments');
		$this->validateOptionalClass('Expression', 'where');
	}

	public function where($expr) {
		$this->where = $expr;
		return $this;
	}
}
