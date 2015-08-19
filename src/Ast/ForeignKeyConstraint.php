<?php

namespace Jitsu\Sql\Ast;

/* A foreign key table constraint.
 *
 * <foreign-key-constraint> ->
 *   ["CONSTRAINT" <identifier>]
 *   "FOREIGN" "KEY" "(" <identifier>+{","} ")"
 *   <foreign-key-clause>
 */
class ForeignKeyConstraint extends ColumnGroupTableConstraint {

	public $references;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('ForeignKeyClause', 'references');
	}
}
