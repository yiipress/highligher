--TEST--
YiiPress\Highlighter::highlight() highlights raw code
--EXTENSIONS--
highlighter
--SKIPIF--
<?php if (!extension_loaded('highlighter')) die('skip highlighter extension not loaded'); ?>
--FILE--
<?php
use YiiPress\Highlighter;

function ok(bool $condition, string $message): void
{
    echo ($condition ? 'ok ' : 'not ok ') . $message . "\n";
}

$code = 'echo "Hello";';
$highlighted = (new Highlighter())->highlight($code, 'php');

ok($highlighted !== $code, 'code was changed');
ok(strpos($highlighted, '<pre') === 0, 'result is preformatted HTML');
ok(strpos($highlighted, 'Hello') !== false, 'code content is present');
ok(strpos($highlighted, '&lt;?php') === false, 'synthetic PHP open tag is stripped');
ok(strpos($highlighted, '<span ') !== false, 'highlight spans are present');
?>
--EXPECT--
ok code was changed
ok result is preformatted HTML
ok code content is present
ok synthetic PHP open tag is stripped
ok highlight spans are present
