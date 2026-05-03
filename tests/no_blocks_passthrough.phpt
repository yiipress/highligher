--TEST--
YiiPress\Highlighter::highlightHtml() returns unchanged HTML without code blocks
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

$html = '<article><p>No code here.</p></article>';
$highlighted = (new Highlighter())->highlightHtml($html);

ok($highlighted === $html, 'html without code blocks is unchanged');
?>
--EXPECT--
ok html without code blocks is unchanged
