<?php

namespace Jitsu\Sql\Ast;

/* An ON or USING clause after a JOIN expression.
 *
 * <join-constraint> ->
 *   <on-constraint> |
 *   <using-constraint>
 */
abstract class JoinConstraint extends Node {

}
