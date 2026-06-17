--TEST--
YiiPress\Highlighter throws for unknown themes
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

$highlighter = new Highlighter();

try {
    $highlighter->highlight('echo "Hello";', 'php', 'Definitely Missing Theme');
    ok(false, 'raw highlight threw RuntimeException');
} catch (RuntimeException $e) {
    ok(strpos($e->getMessage(), 'Unknown highlight theme "Definitely Missing Theme"') === 0, 'raw highlight threw RuntimeException');
}

try {
    $highlighter->highlightHtml('<pre><code class="language-php">echo &quot;Hello&quot;;</code></pre>', 'Definitely Missing Theme');
    ok(false, 'html highlight threw RuntimeException');
} catch (RuntimeException $e) {
    ok(strpos($e->getMessage(), 'Unknown highlight theme "Definitely Missing Theme"') === 0, 'html highlight threw RuntimeException');
}

try {
    $highlighter->highlightHtml('<article><p>No code here.</p></article>', 'Definitely Missing Theme');
    ok(false, 'html highlight without code blocks threw RuntimeException');
} catch (RuntimeException $e) {
    ok(strpos($e->getMessage(), 'Unknown highlight theme "Definitely Missing Theme"') === 0, 'html highlight without code blocks threw RuntimeException');
}
?>
--EXPECT--
ok raw highlight threw RuntimeException
ok html highlight threw RuntimeException
ok html highlight without code blocks threw RuntimeException
