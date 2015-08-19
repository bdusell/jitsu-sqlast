<?php

namespace Jitsu\Sql\Ast;

/* A reference to a column in a FROM clause.
 *
 * <column-reference> ->
 *   [<table-reference> "."] <identifier>
 */
class ColumnReference extends AtomicExpression {

	public $table;
	public $column;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateOptionalClass('TableReference', 'table');
		$this->validateClass('Identifier', 'column');
	}
}
