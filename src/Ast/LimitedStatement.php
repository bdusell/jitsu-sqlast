<?php

namespace Jitsu\Sql\Ast;

/* A complete, executable statement with optional ORDER BY, LIMIT, and OFFSET
 * clauses. */
class LimitedStatement extends Statement {

	public $order_by;
	public $limit;
	public $offset;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateOptionalArray('OrderedExpression', 'order_by');
		$this->validateOptionalClass('Expression', 'limit');
		$this->validateOptionalClass('Expression', 'limit');
	}

	public function orderBy(/* $expr, ... */) {
		$this->order_by = func_get_args();
		return $this;
	}

	public function limit($expr) {
		$this->limit = $expr;
		return $this;
	}

	public function offset($expr) {
		$this->offset = $expr;
		return $this;
	}
}
