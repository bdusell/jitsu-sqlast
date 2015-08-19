<?php

namespace Jitsu\Sql\Ast;

/* Create table statement.
 *
 * <create-table-statement> ->
 *   "CREATE" ["TEMPORARY"] "TABLE" ["IF" "NOT" "EXISTS"]
 *   <table-reference>
 *   "(" <column-definition>+{","} ("," <table-constraint>)* ")"
 *   <table-modifier>*{","}
 */
class CreateTableStatement extends Statement {

	public $temporary;
	public $if_not_exists;
	public $name;
	public $columns;
	public $constraints;
	public $modifiers;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateBool('temporary');
		$this->validateBool('if_not_exists');
		$this->validateClass('TableReference', 'name');
		$this->validateArray('ColumnDefinition', 'columns');
		$this->validateEmptyableArray('TableConstraint', 'constraints');
		$this->validateEmptyableArray('TableModifier', 'modifiers');
	}
}
