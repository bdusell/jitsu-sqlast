<?php

namespace Jitsu\Sql\Ast;

/* An explicit list of expressions on the right side of an IN operator.
 *
 * <simple-in-list> ->
 *   "(" <expression>+{","} ")"
 */
class SimpleInList extends InList {

	public $exprs;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateArray('Expression', 'exprs');
	}
}
