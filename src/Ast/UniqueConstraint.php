<?php

namespace Jitsu\Sql\Ast;

/* A `UNIQUE` table constraint.
 *
 * <unique-constraint> ->
 *   ["CONSTRAINT" <identifier>] "UNIQUE" "(" <identifier>+{","} ")"
 */
class UniqueConstraint extends ColumnGroupTableConstraint {

}
