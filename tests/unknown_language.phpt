--TEST--
YiiPress\Highlighter falls back to plain text for unknown languages
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
$code = 'plain <text> & value';
$raw = $highlighter->highlight($code, 'definitely-not-a-language');
$html = $highlighter->highlightHtml('<pre><code class="language-definitely-not-a-language">plain &lt;text&gt; &amp; value</code></pre>');

ok($raw !== $code, 'raw unknown language returns highlighted HTML');
ok(strpos($raw, 'plain') !== false, 'raw unknown language preserves text');
ok(strpos($raw, '&lt;text&gt;') !== false, 'raw unknown language escapes markup');
ok(strpos($html, 'plain') !== false, 'html unknown language preserves text');
ok(strpos($html, '&lt;text&gt;') !== false, 'html unknown language escapes markup');
?>
--EXPECT--
ok raw unknown language returns highlighted HTML
ok raw unknown language preserves text
ok raw unknown language escapes markup
ok html unknown language preserves text
ok html unknown language escapes markup
