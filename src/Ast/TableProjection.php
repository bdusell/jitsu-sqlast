<?php

namespace Jitsu\Sql\Ast;

/* A table name followed by a list of column names.
 *
 * <table-projection> ->
 *   <table-reference> "(" <identifier>+{","} ")"
 */
class TableProjection extends Node {

	public $table;
	public $columns;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('TableReference', 'table');
		$this->validateArray('Identifier', 'columns');
	}
}
