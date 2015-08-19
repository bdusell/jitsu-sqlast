<?php

namespace Jitsu\Sql\Ast;

/* A primary key table constraint.
 *
 * <index-constraint> ->
 *   "INDEX" [<identifier>] "(" <identifier>+{","} ")"
 */
class IndexConstraint extends ColumnGroupTableConstraint {

}
