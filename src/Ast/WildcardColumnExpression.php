<?php

namespace Jitsu\Sql\Ast;

/* A star (*) in a SELECT clause with an optional table name.
 *
 * <wildcard-column-expression> ->
 *   [<identifier> "."] "*"
 */
class WildcardColumnExpression extends ColumnExpression {

	public $table;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateOptionalClass('Identifier', 'table');
	}
}
