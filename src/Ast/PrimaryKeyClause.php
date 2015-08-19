<?php

namespace Jitsu\Sql\Ast;

/* A primary key clause.
 *
 * <primary-key-clause> ->
 *   "PRIMARY" "KEY"
 */
class PrimaryKeyClause extends KeyClause {

	public function isPrimaryKey() {
		return true;
	}
}
