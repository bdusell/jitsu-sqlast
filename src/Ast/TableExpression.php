<?php

namespace Jitsu\Sql\Ast;

/* A table reference with an optional AS clause.
 *
 * <table-expression> ->
 *   <table-reference> ["AS" <identifier>]
 */
class TableExpression extends FromExpression {

	public $table;
	public $as;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('TableReference', 'table');
		$this->validateOptionalClass('Identifier', 'as');
	}
}
