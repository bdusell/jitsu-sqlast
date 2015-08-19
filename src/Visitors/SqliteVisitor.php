<?php

namespace Jitsu\Sql\Visitors;

class SqliteVisitor extends CodeGenerationVisitor {

	public function __construct($database) {
		parent::__construct($database, new SqlitePrecedenceVisitor);
	}

	public function visitBitfieldType($n) {
		return 'INTEGER';
	}

	public function visitBooleanType($n) {
		return 'INTEGER';
	}

	public function visitIntegerType($n) {
		return 'INTEGER';
	}

	public function visitDecimalType($n) {
		return 'REAL';
	}

	public function visitRealType($n) {
		return 'REAL';
	}

	public function visitDateType($n) {
		return 'TEXT';
	}

	public function visitTimeType($n) {
		return 'TEXT';
	}

	public function visitDatetimeType($n) {
		return 'TEXT';
	}

	public function visitTimestampType($n) {
		return 'INTEGER';
	}

	public function visitYearType($n) {
		return 'INTEGER';
	}

	public function visitFixedStringType($n) {
		return 'TEXT' . self::_strMods($n);
	}

	public function visitStringType($n) {
		return 'TEXT' . self::_strMods($n);
	}

	public function visitByteStringType($n) {
		return 'BLOB';
	}

	public function visitTextType($n) {
		return 'TEXT' . self::_strMods($n);
	}

	public function visitBlobType($n) {
		return 'BLOB';
	}

	private static function _strMods($n) {
		$r = '';
		$collation = self::_collation($n->collation);
		if($collation !== null) {
			$r .= ' COLLATE ' . $collation;
		}
		return $r;
	}

	private static function _collation($collation) {
		switch($collation) {
		case \jitsu\sql\ast\CharacterStringType::CASE_SENSITIVE:
			return 'BINARY';
		case \jitsu\sql\ast\CharacterStringType::CASE_INSENSITIVE:
			return 'NOCASE';
		}
		return null;
	}
}
