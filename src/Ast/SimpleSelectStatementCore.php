<?php

namespace Jitsu\Sql\Ast;

/* A SELECT statement, minus the optional ORDER BY and LIMIT clauses.
 *
 * <simple-select-statement-core> ->
 *   "SELECT" ["DISTINCT"] <column-expression>+{","}
 *   ["FROM" <from-expression>]
 *   ["WHERE" <expression>]
 *   ["GROUP" "BY" <expression>+{","} ["HAVING" <expression>]]
 */
class SimpleSelectStatementCore extends SelectStatementCore {

	public $distinct;
	public $columns;
	public $from;
	public $where;
	public $group_by;
	public $having;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateBool('distinct');
		$this->validateArray('ColumnExpression', 'columns');
		$this->validateOptionalClass('FromExpression', 'from');
		$this->validateOptionalClass('Expression', 'where');
		$this->validateOptionalArray('Expression', 'group_by');
		$this->validateOptionalArray('Expression', 'having');
	}

	public function from($from) {
		$this->from = $from;
		return $this;
	}

	public function where($where) {
		$this->where = $where;
		return $this;
	}

	public function groupBy(/* $expr, ... */) {
		$this->group_by = func_get_args();
		return $this;
	}

	public function having($having) {
		$this->having = $having;
		return $this;
	}
}
