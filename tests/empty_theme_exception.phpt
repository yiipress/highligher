--TEST--
YiiPress\Highlighter rejects empty theme names
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

try {
    (new Highlighter(''))->highlight('echo "Hello";', 'php');
    ok(false, 'empty constructor theme rejected');
} catch (RuntimeException $e) {
    ok($e->getMessage() === 'Highlight theme name must not be empty', 'empty constructor theme rejected');
}

try {
    (new Highlighter())->highlight('echo "Hello";', 'php', '');
    ok(false, 'empty method theme rejected');
} catch (RuntimeException $e) {
    ok($e->getMessage() === 'Highlight theme name must not be empty', 'empty method theme rejected');
}
?>
--EXPECT--
ok empty constructor theme rejected
ok empty method theme rejected
