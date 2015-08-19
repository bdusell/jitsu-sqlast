<?php

namespace Jitsu\Sql\Ast;

/* A table constraint with an optional name and a list of column names. */
class ColumnGroupTableConstraint extends TableConstraint {

	public $name;
	public $columns;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateOptionalClass('Identifier', 'name');
		$this->validateArray('Identifier', 'columns');
	}
}
