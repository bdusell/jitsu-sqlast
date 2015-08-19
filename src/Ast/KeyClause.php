<?php

namespace Jitsu\Sql\Ast;

/* A primary key or uniqueness constraint.
 *
 * <key-clause> ->
 *   <primary-key-clause> | <unique-clause>
 */
class KeyClause extends Node {

	public function isPrimaryKey() {
		return false;
	}
}
