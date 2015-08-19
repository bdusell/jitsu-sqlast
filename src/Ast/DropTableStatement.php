<?php

namespace Jitsu\Sql\Ast;

/* Drop table statement.
 *
 * <drop-table-statement> ->
 *   "DROP" "TABLE" ["IF" "EXISTS"] <table-reference>
 */
class DropTableStatement extends Statement {

	public $if_exists;
	public $table;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateBool('if_exists');
		$this->validateClass('TableReference', 'table');
	}
}
