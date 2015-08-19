<?php

namespace Jitsu\Sql;

class Ast {

	public static function select(/* $column, ... */) {
		return new Ast\SimpleSelectStatementCore(array(
			'distinct' => false,
			'columns' => func_get_args()
		));
	}

	public static function selectDistinct(/* $column, ... */) {
		return new Ast\SimpleSelectStatementCore(array(
			'distinct' => true,
			'columns' => func_get_args()
		));
	}

	private static function _insertMode($table, $mode) {
		return new Ast\InsertStatement(array(
			'type' => $mode,
			'table' => $table
		));
	}

	public static function insert($table) {
		return self::_insertMode($table, Ast\InsertStatement::INSERT);
	}

	public static function insertOrReplace($table) {
		return self::_insertMode($table, Ast\InsertStatement::INSERT_OR_REPLACE);
	}

	public static function insertOrIgnore($table) {
		return self::_insertMode($table, Ast\InsertStatement::INSERT_OR_IGNORE);
	}

	public static function update($table, $assignments) {
		return new Ast\UpdateStatement(array(
			'table' => $table,
			'assignments' => $assignments
		));
	}

	public static function set($name, $expr) {
		return new Ast\Assignment(array(
			'column' => self::name($name),
			'expr' => $expr
		));
	}

	public static function delete($table) {
		return new Ast\DeleteStatement(array(
			'table' => $table
		));
	}

	public static function values(/* $value_array, ... */) {
		return new Ast\ValuesStatementCore(func_get_args());
	}

	public static function row(/* $expr, ... */) {
		return new Ast\ValuesStatementCore(array(func_get_args()));
	}

	public static function star() {
		return new Ast\WildcardColumnExpression(array());
	}

	public static function table($name) {
		return new Ast\TableReference(array(
			'table' => self::name($name)
		));
	}

	public static function col($name) {
		return new Ast\ColumnReference(array(
			'column' => self::name($name)
		));
	}

	public static function name($name) {
		return new Ast\Identifier(array(
			'value' => $name
		));
	}

	public static function value($value = null) {
		if(func_num_args() === 0) {
			return new Ast\AnonymousPlaceholder(array());
		} elseif(is_string($value)) {
			return new Ast\StringLiteral(array('value' => $value));
		} elseif(is_int($value)) {
			return new Ast\IntegerLiteral(array('value' => $value));
		} elseif(is_real($value)) {
			return new Ast\RealLiteral(array('value' => $value));
		} elseif($value === null) {
			return new Ast\NullLiteral(array());
		}
	}

	public static function createTable(
		$name,
		$column_defs,
		$constraints = array(),
		$modifiers = array()
	) {
		return new Ast\CreateTableStatement(array(
			'temporary' => false,
			'if_not_exists' => false,
			'name' => $name,
			'columns' => $column_defs,
			'constraints' => $constraints,
			'modifiers' => $modifiers
		));
	}

	public static function colDef($type, $name, $clauses = array()) {
		$attrs = array(
			'name' => self::name($name),
			'type' => $type
		);
		foreach($clauses as $c) {
			$attrs[self::_getColDefKey($c)] = $c;
		}
		return new Ast\ColumnDefinition($attrs);
	}

	private static function _getDolDefKey($c) {
		if($c instanceof Ast\NotNullClause) {
			return 'not_null';
		} elseif($c instanceof Ast\DefaultValueClause) {
			return 'default';
		} elseif($c instanceof Ast\AutoincrementClause) {
			return 'autoincrement';
		} elseif($c instanceof Ast\KeyClause) {
			return 'key';
		} elseif($c instanceof Ast\ForeignKeyClause) {
			return 'foreign_key';
		} else {
			throw new \InvalidArgumentException(
				'invalid column definition clause');
		}
	}

	public static function primaryKey() {
		$args = func_get_args();
		if($args) {
			return new Ast\PrimaryKeyConstraint(array(
				'columns' => self::names($args)
			));
		} else {
			return new Ast\PrimaryKeyClause(array());
		}
	}

	public static function unique() {
		$args = func_get_args();
		if($args) {
			return new Ast\UniqueConstraint(array(
				'columns' => self::names($args)
			));
		} else {
			return new Ast\UniqueClause(array());
		}
	}

	public static function foreignKey(
		$cols,
		$table = null,
		$foreign_cols = null,
		$attrs = null
	) {
		if(!is_array($cols)) {
			list($cols, $table, $foreign_cols, $attrs) =
				array(null, $cols, $table, $foreign_cols);
		}
		if($attrs === null) $attrs = array();
		$result = new Ast\ForeignKeyClause($attrs + array(
			'table' => $table,
			'columns' => self::names($foreign_cols)
		));
		if($cols !== null) {
			$result = new Ast\ForeignKeyConstraint(array(
				'columns' => self::names($cols),
				'references' => $result
			));
		}
		return $result;
	}

	private static function names($names) {
		if($names === null) return null;
		$result = array();
		foreach($names as $name) {
			$result[] = self::name($name);
		}
		return $result;
	}

	public static function autoincrement() {
		return new Ast\AutoincrementClause(array());
	}

	public static function notNull() {
		return new Ast\NotNullClause(array());
	}

	public static function bitfieldType($width) {
		return new Ast\BitfieldType(array(
			'width' => $width
		));
	}

	public static function boolType() {
		return new Ast\BooleanType(array());
	}

	public static function intType($bytes = 4, $signed = false) {
		return new Ast\IntegerType(array(
			'bytes' => $bytes,
			'signed' => $signed
		));
	}

	public static function decimalType($digits, $decimals) {
		return new Ast\DecimalType(array(
			'digits' => $digits,
			'decimals' => $decimals
		));
	}

	public static function realType($bytes = 8) {
		return new Ast\RealType(array(
			'bytes' => $bytes
		));
	}

	public static function dateType() {
		return new Ast\DateType(array());
	}

	public static function timeType() {
		return new Ast\TimeType(array());
	}

	public static function datetimeType() {
		return new Ast\DatetimeType(array());
	}

	public static function timestampType() {
		return new Ast\TimestampType(array());
	}

	public static function yearType() {
		return new Ast\YearType(array());
	}

	private static function _charset($charset) {
		return $charset === null ? self::ascii() : $charset;
	}

	private static function _collation($collation) {
		return $collation === null ? self::caseSensitive() : $collation;
	}

	private static function _strAttrs($charset, $collation) {
		return array(
			'character_set' => self::_charset($charset),
			'collation' => self::_collation($collation)
		);
	}

	public static function ascii() {
		return Ast\CharacterStringType::ASCII;
	}

	public static function unicode() {
		return Ast\CharacterStringType::UNICODE;
	}

	public static function caseSensitive() {
		return Ast\CharacterStringType::CASE_SENSITIVE;
	}

	public static function caseInsensitive() {
		return Ast\CharacterStringType::CASE_INSENSITIVE;
	}

	public static function fixedStringType(
		$length,
		$charset = null,
		$collation = null
	) {
		return new Ast\FixedStringType(array(
			'length' => $length
		) + self::_strAttrs($charset, $collation));
	}

	public static function stringType(
		$max_length = null,
		$charset = null,
		$collation = null
	) {
		if($max_length === null) $max_length = 255; /* 2^8 - 1 */
		return new Ast\StringType(array(
			'maximum_length' => $max_length
		) + self::_strAttrs($charset, $collation));
	}

	public static function byteStringType($max_length = null) {
		if($max_length === null) $max_length = 255;
		return new Ast\ByteStringType(array(
			'maximum_length' => $max_length
		));
	}

	public static function textType(
		$prefix_size = 2,
		$charset = null,
		$collation = null
	) {
		return new Ast\TextType(array(
			'prefix_size' => $prefix_size
		) + self::_strAttrs($charset, $collation));
	}

	public static function blobType($prefix_size = 2) {
		return new Ast\BlobType(array(
			'prefix_size' => $prefix_size
		));
	}
}
