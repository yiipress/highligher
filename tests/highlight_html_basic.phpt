--TEST--
YiiPress\Highlighter::highlightHtml() highlights an HTML code block
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

$html = '<article><p>Before</p><pre><code class="language-php">&lt;?php echo &quot;Hello&quot;;</code></pre><p>After</p></article>';
$highlighted = (new Highlighter())->highlightHtml($html);

ok($highlighted !== $html, 'html was changed');
ok(strpos($highlighted, '<article><p>Before</p>') !== false, 'prefix was preserved');
ok(strpos($highlighted, '<p>After</p></article>') !== false, 'suffix was preserved');
ok(strpos($highlighted, '<code class="language-php">') === false, 'original code wrapper was replaced');
ok(strpos($highlighted, 'Hello') !== false, 'code content is present');
ok(strpos($highlighted, '<span ') !== false, 'highlight spans are present');
?>
--EXPECT--
ok html was changed
ok prefix was preserved
ok suffix was preserved
ok original code wrapper was replaced
ok code content is present
ok highlight spans are present
