<?php

namespace Jitsu\Sql\Ast;

/* A `WHEN` clause in a `CASE` expression.
 *
 * <when-clause> ->
 *   "WHEN" <expression> "THEN" <expression>
 */
class WhenClause extends Node {

	public $when;
	public $then;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('Expression', 'when');
		$this->validateClass('Expression', 'then');
	}
}
