<?php

namespace Jitsu\Sql\Ast;

/* A subquery to the right of an `IN` operator.
 *
 * <select-in-list> ->
 *   "(" <select-statement> ")"
 */
class SelectInList extends InList {

	public $select;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateClass('SelectStatement', 'select');
	}
}
