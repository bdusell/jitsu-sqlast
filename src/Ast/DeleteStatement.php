<?php

namespace Jitsu\Sql\Ast;

/* A complete DELETE statement.
 *
 * <delete-statement> ->
 *   "DELETE" "FROM" <table-reference>
 *   ["WHERE" <expression>]
 *   ["ORDER" "BY" <ordered-expression>+{","}]
 *   ["LIMIT" <expression> ["OFFSET" <expression>]]
 */
class DeleteStatement extends LimitedStatement {

	public $table;
	public $where;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('TableReference', 'table');
		$this->validateOptionalClass('Expression', 'where');
	}

	public function where($expr) {
		$this->where = $expr;
		return $this;
	}
}
