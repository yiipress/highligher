AC_PATH_PROG([CARGO], [cargo], [no])
if test "$CARGO" = "no"; then
  AC_MSG_ERROR([cargo is required to build ext-highlighter])
fi

HIGHLIGHTER_DIR="$HIGHLIGHTER_SOURCE"
if test -z "$HIGHLIGHTER_DIR" && test -f "$ext_srcdir/Cargo.toml"; then
  HIGHLIGHTER_DIR="$ext_srcdir"
fi
if test -z "$HIGHLIGHTER_DIR" || test ! -f "$HIGHLIGHTER_DIR/Cargo.toml"; then
  HIGHLIGHTER_DIR="$srcdir"
fi

if test -z "$HIGHLIGHTER_VERSION"; then
  AC_PATH_PROG([GIT], [git], [no])
  if test "$GIT" != "no"; then
    HIGHLIGHTER_VERSION=`(cd "$HIGHLIGHTER_DIR" && "$GIT" describe --tags --dirty --always 2>/dev/null) || true`
  fi
fi
if test -z "$HIGHLIGHTER_VERSION"; then
  HIGHLIGHTER_VERSION=`basename "$HIGHLIGHTER_DIR" | sed -n 's/^.*-\([0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f][0-9a-f]*\)$/\1/p'`
fi
if test -z "$HIGHLIGHTER_VERSION"; then
  HIGHLIGHTER_VERSION="unknown"
fi
HIGHLIGHTER_VERSION=`printf '%s' "$HIGHLIGHTER_VERSION" | sed 's/[^A-Za-z0-9._+:-]/_/g'`
AC_MSG_NOTICE([using highlighter version $HIGHLIGHTER_VERSION])
AC_DEFINE_UNQUOTED([PHP_HIGHLIGHTER_VERSION], ["$HIGHLIGHTER_VERSION"], [Version reported by the highlighter extension])

HIGHLIGHTER_TARGET_DIR="$HIGHLIGHTER_DIR/target/release"
HIGHLIGHTER_CARGO_ARGS="build --release"
if test -n "$CARGO_BUILD_TARGET"; then
  HIGHLIGHTER_CARGO_ARGS="$HIGHLIGHTER_CARGO_ARGS --target $CARGO_BUILD_TARGET"
  HIGHLIGHTER_TARGET_DIR="$HIGHLIGHTER_DIR/target/$CARGO_BUILD_TARGET/release"
fi

AC_MSG_NOTICE([building Rust highlighter static library])
(cd "$HIGHLIGHTER_DIR" && "$CARGO" $HIGHLIGHTER_CARGO_ARGS) || AC_MSG_ERROR([failed to build Rust highlighter static library])

ext_shared=yes
PHP_ADD_INCLUDE([$HIGHLIGHTER_DIR])
PHP_ADD_LIBRARY_WITH_PATH([highlighter], [$HIGHLIGHTER_TARGET_DIR], [HIGHLIGHTER_SHARED_LIBADD])
PHP_ADD_LIBRARY([pthread], [1], [HIGHLIGHTER_SHARED_LIBADD])
PHP_ADD_LIBRARY([dl], [1], [HIGHLIGHTER_SHARED_LIBADD])
PHP_ADD_LIBRARY([m], [1], [HIGHLIGHTER_SHARED_LIBADD])
PHP_SUBST([HIGHLIGHTER_SHARED_LIBADD])
PHP_NEW_EXTENSION([highlighter], [highlighter.c], [yes])
