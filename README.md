jitsu/sqlast
------------

This package implements a SQL syntax abstraction layer. The two backends
currently supported are MySQL and SQLite.

## Grammar

The grammar for the abstract SQL language is below. In general, each kind of
non-terminal symbol corresponds to a class.

    <stmt> ->
        <select-stmt> |
        <insert-stmt> |
        <update-stmt> |
        <delete-stmt> |
        <create-table-stmt> |
        <drop-table-stmt>

    <select-stmt> ->
        <select-stmt-core>
        ["order" "by" <ordered-expr>+{","}]
        ["limit" <expr> ["offset" <expr>]]

    <select-stmt-core> ->
        <compound-select-stmt-core> |
        <simple-select-stmt-core> |
        <values-statement>

    <compound-select-stmt-core> ->
        <select-stmt-core> <union-operator> <select-stmt-core>

    <union-operator> ->
        "union" ["all"]

    <simple-select-stmt-core> ->
        "select" ["distinct" | "all"] <col-expr>+{","}
        ["from" <from-expr>]
        ["where" <expr>]
        ["group" "by" <expr>+{","} ["having" <expr>] ]

    <values-statement> ->
        "values" ("(" <expr>+{","} ")")+{","}

    <col-expr> ->
        <simple-col-expr> |
        <wildcard-col-expr>

    <simple-col-expr> ->
        <expr> ["as" <identifier>]

    <wildcard-col-expr> ->
        [<identifier> "."] "*"

    <from-expr> ->
        <join-expr> |
        <table-expr> |
        <select-expr-in-from> |
        "(" <from-expr> ")"

    <join-expr> ->
        <from-expr> <join-operator> <from-expr> [<join-constraint>]

    <join-constraint> ->
        <on-constraint> |
        <using-constraint>

    <on-constraint> ->
        "on" <expr>

    <using-constraint> ->
        "using" "(" <identifier>+{","} ")"

    <join-operator> ->
        "," |
        [
        	"inner" | "left" ["outer"] | "right" ["outer"] |
        	"full" ["outer"] | "cross"
        ] "join"

    <table-expr> ->
        <table-ref> ["as" <identifier>]

    <table-ref> ->
        [<identifier> "."] <identifier>

    <select-expr-in-from> ->
        <select-expr>

    <select-expr> ->
        "(" <select-stmt> ")" [ ["as"] <identifier> ]

    <ordered-expr> ->
        <expr> ["asc" | "desc"]

    <expr> ->
        <atomic-expr> |
        <collate-expr> |
        <unary-expr> |
        <binary-expr> |
        <in-expr> |
        <like-expr> |
        <between-expr> |
        <case-expr>

    <atomic-expr> ->
        <literal-expr> |
        <col-ref> |
        <placeholder> |
        <function-call> |
        <cast-expr> |
        <exists-expr> |
        <select-expr>

    <literal-expr> ->
        <integer-literal> |
        <real-literal> |
        <string-literal> |
        <null-literal>

    <null-literal> ->
        "null"

    <col-ref> ->
        [<table-ref> "."] <identifier>

    <placeholder> ->
        <anonymous-placeholder> |
        <named-placeholder>

    <anonymous-placeholder> ->
        "?"

    <named-placeholder> ->
        ":<name>"

    <function-call> ->
        <function-name> "(" ["*" | ["distinct"] <expr>+{","}] ")"

    <function-name> ->
        ...

    <cast-expr> ->
        "cast" "(" <expr> "as" <type> ")"

    <type> ->
        <type-name>
        ["character" "set" <character-set-name>]
        ["collate" <collation-name>]

    <type-name> ->
        ...

    <exists-expr> ->
        "exists" "(" <select-stmt> ")"

    <collate-expr> ->
        <expr> "collate" <collation-name>

    <collation-name> ->
        "binary" | ...

    <character-set-name> ->
        ...

    <negation-expr> ->
        "-" <expr>

    <unary-expr> ->
        <negation-expr> |
        <not-expr>

    <binary-expr> ->
        <concat-expr> |
        <mul-expr> |
        <div-expr> |
        <mod-expr> |
        <add-expr> |
        <sub-expr> |
        <lt-expr> |
        <le-expr> |
        <gt-expr> |
        <ge-expr> |
        <eq-expr> |
        <ne-expr> |
        <is-expr> |
        <and-expr> |
        <or-expr>

    <concat-expr> ->
        <expr> "||" <expr>

    <mul-expr> ->
        <expr> "*" <expr>

    <div-expr> ->
        <expr> "/" <expr>

    <add-expr> ->
        <expr> "+" <expr>

    <sub-expr> ->
        <expr> "-" <expr>

    <lt-expr> ->
        <expr> "<" <expr>

    <le-expr> ->
        <expr> "<=" <expr>

    <gt-expr> ->
        <expr> ">" <expr>

    <ge-expr> ->
        <expr> ">=" <expr>

    <eq-expr> ->
        <expr> "=" <expr>

    <ne-expr> ->
        <expr> "!=" <expr>

    <is-expr> ->
        <expr> "is" <expr>

    <in-expr> ->
        <expr> "in" <in-list>

    <in-list> ->
        <simple-in-list> |
        <select-in-list> |
        <table-in-list>

    <simple-in-list> ->
        "(" <select-stmt> ")"

    <select-in-list> ->
        "(" <expr>+{","} ")"

    <table-in-list> ->
        <table-ref>

    <like-expr> ->
        <expr> "like" <expr> ["escape" <expr>]

    <not-expr> ->
        "not" <expr>

    <and-expr> ->
        <expr> "and" <expr>

    <or-expr> ->
        <expr> "or" <expr>

    <between-expr> ->
        <expr> "between" <expr> "and" <expr>

    <case-expr> ->
        "case" [<expr>] <when-clause>+ ["else" <expr>] "end"

    <when-clause> ->
        "when" <expr> "then" <expr>

    <insert-statement> ->
        <insert-type> "into" <table-projection>
        (<select-statement> | "default" "values")

    <insert-type> ->
        "insert" |
        "insert" "or" "replace" / "replace" (MySQL) |
        "insert" "or" "ignore"

    <table-projection> ->
        <table-ref> "(" <col-ref>+{","} ")"

    <update-stmt> ->
        <update-type> <table-ref>
        "set" (<identifier> "=" <expr>)+{","}
        ["where" <expr>]
        ["order" "by" <ordered-expr>+{","}]
        ["limit" <expr> ["offset" <expr>]]

    <update-type> ->
        "update"

    <delete-stmt> ->
        "delete" "from" <table-ref> ["where" <expr>]

    <create-table-stmt> ->
        "create" ["temporary"] "table" ["if" "not" "exists"]
        <table-ref> "("
        <column-definition>+{","}
        ("," <table-constraint>)*
        ")"
        <table-modifier>*{","}

    <table-modifier> ->
        ...

    <column-definition> ->
        <identifier> <type>
        [<collate-clause>]
        [<not-null-clause>]
        [<default-value-clause>]
        [<autoincrement-clause>]
        [<key-clause>]
        [<foreign-key-clause>]

    <not-null-clause> ->
        "not" "null"

    <default-value-clause> ->
        "default" ( <literal-expr> | "(" <expr> ")" )

    <autoincrement-clause> ->
        "autoincrement" (SQLite) / "auto_increment" (MySQL)

    <key-clause> ->
        <primary-key-clause> |
        <unique-clause>

    <primary-key-clause> ->
        "primary" "key"

    <unique-clause> ->
        "unique"

    <table-constraint> ->
        <primary-key-constraint> |
        <index-constraint> |
        <unique-constraint> |
        <foreign-key-constraint> |
        <check-constraint>

    <primary-key-constraint> ->
        ["constraint" <identifier>] "primary" "key" "(" <identifier>+{","} ")"

    <index-constraint> ->
        "index" [<identifier>] "(" <identifier>+{","} ")"

    <unique-constraint> ->
        ["constraint" <identifier>] "unique" "(" <identifier>+{","} ")"

    <foreign-key-constraint> ->
        ["constraint" <identifier>] "foreign" "key" "(" <identifier>+{","} ")" <foreign-key-clause>

    <check-constraint> ->
        "check" "(" <expr> ")"

    <foreign-key-clause> ->
        "references" <table-ref>
        ["(" <identifier>+{","} ")"]
        ["on" "delete" <foreign-key-trigger-name>]
        ["on" "update" <foreign-key-trigger-name>]
        [
        	["not"] "deferrable"
        	["initially" ("deferred" | "immediate")]
        ]

    <foreign-key-trigger-name> ->
        "set" "null" |
        "cascade" |
        "restrict" |
        "no" "action"

    <drop-table-stmt> ->
        "drop" "table" ["if" "exists"] <table-ref>

## Notes on Data Types

### MySQL Data Types

#### Numeric

* `BIT(M=1)`, 1 <= `M` <= 64: A bit field. Sometimes a synonym for
  `TINYINT(1)`.
* `TINYINT(M) [UNSIGNED]`: A very small integer. Signed range is [-128, 127].
  Unsigned range is [0, 255].
* `BOOL` / `BOOLEAN`: Synonym for `TINYINT(1)`. Boolean semantics.
* `SMALLINT(M) [UNSIGNED]`: A small integer. Signed range is [-32768, 32767].
  Unsigned range is [0, 65535].
* `MEDIUMINT(M) [UNSIGNED]`: Medium-sized integer. Signed range is [-8388608,
  8388607]. Unsigned range is [0, 16777215].
* `INT(M)` / `INTEGER(M) [UNSIGNED]`: Normal-sized integer.
* `BIGINT(M) [UNSIGNED]`: Large integer.
* `SERIAL`: An alias for `BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE`.
* `DECIMAL` / `DEC` / `NUMERIC` / `FIXED (M=10, D=0) [UNSIGNED]`, `M` <= 65,
  `D` <= 30: Fixed-point number. `M` is the total number of digits, and `D` is
  the number of decimal digits after the decimal point.
* `FLOAT(M, D) [UNSIGNED]`: Single-precision floating-point number. `M` is the
  total number of digits, and `D` is the number of digits after the decimal
  point.
* `DOUBLE` / `DOUBLE PRECISION` / `REAL (M, D) [UNSIGNED]`: Double-precision
  floating-point number.
* `FLOAT(p) [UNSIGNED]`: Synonym for either `FLOAT` or `DOUBLE` depending on
  the precision `p` given.

#### Date and Time

* `DATE`: A date in the range [1000-01-01, 9999-12-31]. String format is
  `YYYY-MM-DD`.
* `DATETIME`: A date and time. String format is `YYYY-MM-DD HH:MM:SS`.
* `TIMESTAMP`: Unix timestamp. The epoch is `1970-01-01 00:00:00 UTC`. See also
  `DEFAULT CURRENT_TIMESTAMP` and `ON UPDATE CURRENT_TIMESTAMP`.
* `TIME`: A time of day. String format is `HH:MM:SS`.
* `YEAR(2|4)`: A year in two or four digit format. In either case the range is
  [1901, 2155].

See also `SEC_TO_TIME`, `TIME_TO_SEC`, `FROM_DAYS`, `TO_DAYS`.

#### String

* attribute `CHARACTER SET` / `CHARSET`: The character set, e.g. `binary`,
  `utf8`, `latin1`.
* attribute `COLLATE`: The collation, e.g. `latin1_general_cs`.
* attribute `ASCII`: Shorthand for `CHARACTER SET latin1`.
* attribute `UNICODE`: Shorthand for CHARACTER SET `ucs2`.
* attribute `BINARY`: Shorthand for specifying binary collation. Causes
  characters to be compared by codepoint.
* modifier `NATIONAL`: The standard SQL way to prefix a string type which uses
  a custom character set, e.g. `NATIONAL CHAR(255) CHARACTER SET utf8`.
* `CHAR` / `CHARACTER (M=1)`, 0 <= `M` <= 255: A fixed-length string of length
  `M`, right-padded with spaces which are automatically stripped when it is
  retrieved. `CHAR(0)` can be used as a dummy column whose values are not
  actually used.
* `NCHAR`: Synonym for `NATIONAL CHAR`.
* `VARCHAR(M)`, 0 <= `M` <= 65,535: A variable-length string with maximum size
  `M`. The effective maximum number of characters depends on the character set.
  The length limitation comes from the size of the length prefix used. Only one
  byte is used if the values require no more than 255 bytes; two bytes are used
  otherwise. Trailing spaces are preserved, unlike `CHAR`.
* `BINARY(M)` / `CHAR(M) BINARY`: Binary version of `CHAR`.
* `VARBINARY(M)` / `VARCHAR(M) BINARY`: Binary version of VARCHAR.
* `TINYBLOB`: A `BLOB` with a maximum length of 255 due to its 1-byte length
  prefix.
* `TINYTEXT`: `TEXT` with a maximum length of 255 due to its 1-byte length
  prefix.
* `BLOB(M)` / `TEXT(M) BINARY`: Binary data with a maximum length of 65,535.
* `TEXT(M)`, `M` <= 65,535: Text column.
* `MEDIUMBLOB`: `BLOB` with a 3-byte length prefix.
* `MEDIUMTEXT`: TEXT with a 3-byte length prefix.
* `LONGBLOB`: `BLOB` with a 4-byte length prefix.
* `LONGTEXT`: `TEXT` with a 4-byte length prefix.
* `ENUM('value1', 'value2', ...)`: Enumerated type. Possible values are those
  listed plus `NULL` and the special error value `''`. Represented internally
  as integers.
* `SET('value1', 'value2', ...)`: Set type which may contain zero or more of
  the listed values. Represented internally as integers. Maximum of 64 distinct
  members.

#### MySQL Mappings for Common SQL Data Types

| Standard SQL           | MySQL        |
|------------------------|--------------|
| `BOOL` / `BOOLEAN`     | `TINYINT`    |
| `CHARACTER VARYING(M)` | `VARCHAR(M)` |
| `FIXED` / `NUMERIC`    | `DECIMAL`    |
| `FLOAT4`               | `FLOAT`      |
| `FLOAT8`               | `DOUBLE`     |
| `INT1`                 | `TINYINT`    |
| `INT2`                 | `SMALLINT`   |
| `INT3`                 | `MEDIUMINT`  |
| `INT4`                 | `INT`        |
| `INT8`                 | `BIGINT`     |
| `LONG VARBINARY`       | `MEDIUMBLOB` |
| `LONG VARCHAR`         | `MEDIUMTEXT` |
| `LONG`                 | `MEDIUMTEXT` |
| `MIDDLEINT`            | `MEDIUMINT`  |

### SQLite Data Types

#### Storage Classes

* `NULL`
* `INTEGER`: Signed integer stored in 1, 2, 3, 4, 6, or 8 bytes depending on
  the magnitude. Always read into memory as an 8-byte signed integer.
* `REAL`: 8-byte floating-point value.
* `TEXT`: A string. The encoding {UTF-8, UTF-16BE, UTF-16LE} used is
  database-wide.
* `BLOB`: Binary blob of data. What you put in is what you get out.

#### Data Types

##### Boolean

There is no boolean type; integers 0 and 1 are used instead.

##### Date and Time

There are no date or time types. Instead they can be stored as TEXT in the
format "YYYY-MM-DD HH:MM:SS.SSS", REAL in the form of Julian day numbers (the
number of days since noon in Greenwich on Nov. 24, 4714 B.C. according to the
proleptic Gregorian calendar), or `INTEGER` in the form of a Unix timestamp.

#### SQLite Affinity Mappings for Common SQL Data Types

| Standard SQL         | SQLite    |
|----------------------|-----------|
| `*INT*`              | `INTEGER` |
| `*(CHAR|CLOB|TEXT)*` | `TEXT`    |
| `*BLOB*`             | `NONE`    |
| `*(REAL|FLOA|DOUB)*` | `REAL`    |
| anything else        | `NUMERIC` |

#### Collations

* `BINARY`: Uses `memcmp()`. This is the default.
* `NOCASE`: Case-insensitive version of `BINARY`. Applies to ASCII only.
* `RTRIM`: Ignores trailing whitespace.
* _custom_: Can be registered through `sqlite_create_collation()`.

### Abstract Data Types

#### Field Types

##### `BITFIELD(WIDTH)`

MySQL:   `BIT(width)`, 1 <= `width` <= 64
SQLite:  `INT`
PHP:     `int`
Example: `"permissions" BITFIELD(10)`

##### `BOOLEAN`

MySQL:   `BOOL`
SQLite:  `INT`
PHP:     `bool`
Example: `"admin" BOOLEAN`

##### `INTEGER(BYTES, SIGNED)`

MySQL:   `TINYINT(1)/SMALLINT(2)/MEDIUMINT(3)/INT(4)/BIGINT(8)`
SQLite:  `INT`
PHP:     `int`
Example: `"views" INTEGER(6, TRUE)`

##### `DECIMAL(DIGITS, DECIMALS)`

MySQL:   `DECIMAL/DEC/NUMERIC/FIXED(M, D)`, `M` <= 65, `D` <= 30
SQLite:  `FLOAT` + `ROUND()`
PHP:     `real` / `string` / special Decimal type?
Example: `"price" DECIMAL(11, 2)`

##### `REAL(BYTES)`

MySQL:   `FLOAT/DOUBLE/REAL(M, D)`
SQLite:  `REAL`
PHP:     `real`
Example: `"ph" REAL(4)`

##### `DATE`

MySQL:   `DATE`
SQLite:  `STRING` + `DATE()`
PHP:     `int` / `string` / `array(int, int, int)` ?
Example: `"birthdate" DATE`

##### `TIME`

MySQL:   `TIME`
SQLite:  `STRING` + `TIME()`
PHP:     `int` / `string` / `array(int, int, int)` ?
Example: `"departure" TIME`

##### `DATETIME`

MySQL:   `DATETIME`
SQLite:  `STRING` + `DATETIME()`
PHP:     `int` / `string` / `array` ?
Example: `"created_at" DATETIME`

##### `TIMESTAMP`

MySQL:   `TIMESTAMP`
SQLite:  `INTEGER` + `DATETIME(n, 'unixepoch')`
PHP:     `int`
Example: `"access_time" TIMESTAMP`

##### `YEAR`

MySQL:   `YEAR`
SQLite:  `STRING` + `STRFTIME('%Y')`
PHP:     `int`
Example: `"published_in" YEAR`

##### `FIXEDSTRING(LENGTH) CHARSET`

MySQL:   `CHAR`/`CHARACTER(N)`
SQLite:  `TEXT`
PHP:     `string`
Example: `"iso_code" FIXEDSTRING(3)`

##### `STRING(MAXLENGTH) CHARSET`

MySQL:   `VARCHAR(N)`
SQLite:  `TEXT`
PHP:     `string`
Example: `"name" STRING(50)`, `"title" STRING(100)`

##### `BYTESTRING(MAXLENGTH)`

MySQL:   `VARBINARY(N)`
SQLite:  `BLOB`
PHP:     `string`
Example: `"raw_input" BYTESTRING(255)`

##### `TEXT(PREFIXSIZE) CHARSET`

MySQL:   `TINYTEXT(1)/TEXT(2)/MEDIUMTEXT(3)/LONGTEXT(4)`
SQLite:  `TEXT`
PHP:     `string`
Example: `"content" TEXT(4)`

##### `BLOB(PREFIXSIZE)`

MySQL:   `TINYBLOB(1)/BLOB(2)/MEDIUMBLOB(3)/LONGBLOB(4)`
SQLite:  `BLOB`
PHP:     `string`
Example: `"gif_data" BLOB(2)`

### Field Type Summary

#### Artificial Types

* `KEY [AUTOINCREMENT]`

#### Numeric Types

* `INTEGER(BYTES=4) [UNSIGNED]`
* `REAL(PRECISION=double) [UNSIGNED]`
* `BOOLEAN`
* `DECIMAL(BEFORE, AFTER) [UNSIGNED]`
* `BITFIELD(BITS)`

#### Temporal Types

* `TIMESTAMP`
* `DATETIME(FORMAT=YYYY-MM-DD HH:MM:SS)`
* `DATE(FORMAT=YYYY-MM-DD)`
* `TIME(FORMAT=HH:MM:SS)`
* `YEAR`

#### String Types

* `STRING(MAXLENGTH) [CHARSET ENCODING=utf8] [COLLATE COLLATION=binary]`
* `TEXT(PREFIXSIZE=4) [CHARSET ENCODING=utf8] [COLLATE COLLATION=binary]`
* `FIXEDSTRING(LENGTH) [CHARSET ENCODING=ascii] [COLLATE COLLATION=binary]`

#### Binary Types

* `BINARY(MAXLENGTH)`
* `BLOB(PREFIXSIZE=4)`
* `FIXEDBINARY(LENGTH)`
