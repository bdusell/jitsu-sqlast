<?php

namespace Jitsu\Sql\Ast;

/* A column definition.
 *
 * <column-definition> ->
 *   <identifier> <type>
 *   [<collate-clause>]
 *   [<not-null-clause>]
 *   [<default-value-clause>]
 *   [<autoincrement-clause>]
 *   [<key-clause>]
 *   [<foreign-key-clause>]
 */
class ColumnDefinition extends Node {

	public $name;
	public $type;
	public $not_null;
	public $default;
	public $autoincrement;
	public $key;
	public $foreign_key;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Identifier', 'name');
		$this->validateClass('Type', 'type');
		$this->validateOptionalClass('NotNullClause', 'not_null');
		$this->validateOptionalClass('DefaultValueClause', 'default');
		$this->validateOptionalClass('AutoincrementClause', 'autoincrement');
		$this->validateOptionalClass('KeyClause', 'key');
		$this->validateOptionalClass('ForeignKeyClause', 'foreign_key');
	}

	public function notNull() {
		$this->not_null = new NotNullClause(array());
		return $this;
	}

	public function defaultValue($expr) {
		$this->default = new DefaultValueClause(array(
			'expr' => $expr
		));
		return $this;
	}

	public function autoincrement() {
		$this->autoincrement = new AutoincrementClause(array());
		return $this;
	}

	public function primaryKey() {
		$this->key = new PrimaryKeyClause(array());
		return $this;
	}

	public function isPrimaryKey() {
		return $this->key && $this->key->isPrimaryKey();
	}

	public function unique() {
		$this->key = new UniqueClause(array());
		return $this;
	}

	public function foreignKey($fk_clause) {
		$this->key = $fk_clause;
		return $this;
	}
}
