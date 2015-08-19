<?php

namespace Jitsu\Sql\Ast;

/* A primary key table constraint.
 *
 * <primary-key-constraint> ->
 *   ["CONSTRAINT" <identifier>]
 *   "PRIMARY" "KEY" "(" <identifier>+{","} ")"
 */
class PrimaryKeyConstraint extends ColumnGroupTableConstraint {

}
