<?php

namespace Jitsu\Sql\Ast;

/* A table reference on the right side of an `IN` operator.
 *
 * <table-in-list> ->
 *   <table-reference>
 */
class TableInList extends InList {

	public $table;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('TableReference', 'table');
	}
}
