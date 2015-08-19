<?php

namespace Jitsu\Sql\Ast;

/* A named placeholder for a bind parameter.
 *
 * <named-placeholder> ->
 *   ":[some name]"
 */
class NamedPlacholder extends Placeholder {

	public $name;

	public function __construct($attrs) {
		parent::__construct($attrs);
		$this->validateString('name');
	}
}
