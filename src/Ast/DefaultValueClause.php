<?php

namespace Jitsu\Sql\Ast;

/* A default value clause.
 *
 * <default-value-clause> ->
 *   "DEFAULT" ( <literal-expr> | "(" <expr> ")" )
 */
class DefaultValueClause extends Node {

	public $value;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'value');
	}
}
