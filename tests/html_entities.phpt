--TEST--
YiiPress\Highlighter::highlightHtml() decodes common HTML entities before highlighting
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

$html = '<pre><code class="language-php">echo &#039;x&#039;;</code></pre>';
$highlighted = (new Highlighter())->highlightHtml($html);

ok(strpos($highlighted, '&#39;x&#39;') !== false, 'numeric apostrophe entity was decoded');
ok(strpos($highlighted, '&#039;') === false, 'numeric apostrophe entity was not preserved as text');
ok(strpos($highlighted, '&amp;#039;') === false, 'numeric apostrophe entity was not double escaped');
?>
--EXPECT--
ok numeric apostrophe entity was decoded
ok numeric apostrophe entity was not preserved as text
ok numeric apostrophe entity was not double escaped
