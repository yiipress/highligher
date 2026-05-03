--TEST--
YiiPress\Highlighter::highlightHtml() highlights multiple code blocks
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

$html = '<h1>Examples</h1>'
    . '<pre><code class="language-php">echo &quot;One&quot;;</code></pre>'
    . '<p>Between</p>'
    . '<pre><code class="language-javascript">console.log(&quot;Two&quot;);</code></pre>';

$highlighted = (new Highlighter())->highlightHtml($html);

ok($highlighted !== $html, 'html was changed');
ok(strpos($highlighted, '<h1>Examples</h1>') !== false, 'leading html was preserved');
ok(strpos($highlighted, '<p>Between</p>') !== false, 'middle html was preserved');
ok(substr_count($highlighted, '<pre') === 2, 'two highlighted blocks are present');
ok(strpos($highlighted, 'One') !== false, 'first block content is present');
ok(strpos($highlighted, 'Two') !== false, 'second block content is present');
?>
--EXPECT--
ok html was changed
ok leading html was preserved
ok middle html was preserved
ok two highlighted blocks are present
ok first block content is present
ok second block content is present
