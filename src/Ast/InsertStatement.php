<?php

namespace Jitsu\Sql\Ast;

/* A complete INSERT statement.
 *
 * <insert-statement> ->
 *   ("INSERT" ["OR" ("REPLACE" | "IGNORE")] | "REPLACE")
 *   "INTO" <table-projection>
 *   (<select-statement> | "DEFAULT" "VALUES")
 */
class InsertStatement extends Statement {

	const INSERT = 'INSERT';
	const INSERT_OR_REPLACE = 'INSERT OR REPLACE';
	const INSERT_OR_IGNORE = 'INSERT OR IGNORE';

	public $type;
	public $table;
	public $select;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateConst('type');
		$this->validateClass('TableProjection', 'table');
		$this->validateOptionalClass('SelectStatement', 'select');
	}

	public function values(/* $int | $expr1, ... */) {
		if(func_num_args() === 1 && is_int($n = func_get_arg(0))) {
			$exprs = array();
			for($i = 0; $i < $n; ++$i) {
				$exprs[] = new AnonymousPlaceholder(array());
			}
		} else {
			$exprs = func_get_args();
		}
		$this->select = new SelectStatement(array(
			'core' => new ValuesStatementCore(array(
				'values' => array($exprs)
			))
		));
		return $this;
	}
}
