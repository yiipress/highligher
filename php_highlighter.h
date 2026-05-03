#ifndef PHP_HIGHLIGHTER_H
#define PHP_HIGHLIGHTER_H

extern zend_module_entry highlighter_module_entry;
#define phpext_highlighter_ptr &highlighter_module_entry

#ifndef PHP_HIGHLIGHTER_VERSION
#define PHP_HIGHLIGHTER_VERSION "unknown"
#endif

#define PHP_HIGHLIGHTER_DEFAULT_THEME "InspiredGitHub"

#if defined(ZTS) && defined(COMPILE_DL_HIGHLIGHTER)
ZEND_TSRMLS_CACHE_EXTERN()
#endif

#endif
