<?php

namespace Jitsu\Sql\Ast;

/* Abstract syntax tree node base class. */
abstract class Node {

	/* Use an array of values to set members. */
	public function __construct($attrs) {
		foreach($attrs as $name => $value) {
			$this->$name = $value;
		}
	}

	/* Accept a visitor. */
	public function accept($v) {
		return call_user_func(array($v, 'visit' . self::_myName()), $this);
	}

	private static function _myName() {
		$class = get_called_class();
		$end = strrchr($class, '\\');
		return $end === false ? $class : substr($end, 1);
	}

	private function _fullClassName($name) {
		return __NAMESPACE__ . '\\' . $name;
	}

	protected function validateClass($class, $prop) {
		$value = $this->$prop;
		$full_class = $this->_fullClassName($class);
		if(!($value instanceof $full_class)) {
			$this->error($prop, 'must be of type ' . $full_class);
		}
	}

	protected function validateOptionalClass($class, $prop) {
		if($this->$prop !== null) {
			$this->validateClass($class, $prop);
		}
	}

	protected function validateArray($class, $prop) {
		$this->validateEmptyableArray($class, $prop);
		if(count($this->$prop) === 0) {
			$this->error($prop, 'must not be an empty array');
		}
	}

	protected function validateEmptyableArray($class, $prop) {
		$value = $this->$prop;
		$full_class = $this->_fullClassName($class);
		if(!is_array($value)) {
			$this->error($prop, 'must be an array of ' . $full_class);
		}
		foreach($value as $subvalue) {
			if(!($subvalue instanceof $full_class)) {
				$this->error($prop, 'must be an array of ' . $full_class);
			}
		}
	}

	protected function validateOptionalArray($class, $prop) {
		if($this->$prop !== null) {
			$this->validateArray($class, $prop);
		}
	}

	protected function validateArrayArray($class, $prop) {
		$value = $this->$prop;
		$full_class = $this->_fullClassName($class);
		if(!is_array($value)) {
			$this->error($prop, 'must be an array or arrays of ' . $full_class);
		}
		foreach($value as $subvalue) {
			if(!is_array($subvalue)) {
				$this->error($prop, 'must be an array or arrays of ' . $full_class);
			}
			foreach($subvalue as $subsubvalue) {
				if(!($subsubvalue instanceof $full_class)) {
					$this->error($prop, 'must be an array of arrays of ' . $full_class);
				}
			}
		}
	}

	protected function validateConst($prop) {
		$this->validateString($prop);
	}

	protected function validateOptionalConst($prop) {
		if($this->$prop !== null) {
			$this->validateConst($prop);
		}
	}

	protected function validateString($prop) {
		if(!is_string($this->$prop)) {
			$this->error($prop, 'must be a string');
		}
	}

	protected function validateBool($prop) {
		if(!is_bool($this->$prop)) {
			$this->error($prop, 'must be a boolean');
		}
	}

	protected function validateOptionalBool($prop) {
		if($this->$prop !== null) {
			$this->validateBool($prop);
		}
	}

	protected function validateInt($prop) {
		if(!is_int($this->$prop)) {
			$this->error($prop, 'must be an integer');
		}
	}

	protected function validateFloat($prop) {
		if(!is_float($this->$prop)) {
			$this->error($prop, 'must be a float');
		}
	}

	private function error($prop, $msg) {
		throw new \InvalidArgumentException(
			get_class($this) . '->' . $prop . ' ' . $msg
		);
	}
}
